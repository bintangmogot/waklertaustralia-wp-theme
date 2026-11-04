"""Generate ACF field definitions from the theme's content registries.

Usage: python tools/generate-content-fields.py [--prune-unused]
This changes field definitions only. WordPress values are installed by the PHP
empty-only seeder, never by this tool.
"""
import argparse,json,re
from pathlib import Path
ROOT=Path(__file__).resolve().parents[1]
parser=argparse.ArgumentParser();parser.add_argument('--prune-unused',action='store_true');args=parser.parse_args()
module_path=ROOT/'acf-json/group_page_modules.json'
module_group=json.loads(module_path.read_text('utf8'))
layouts={v['name']:v for v in module_group['fields'][0]['layouts'].values()}
settings_path=ROOT/'acf-json/group_theme_settings.json'
settings=json.loads(settings_path.read_text('utf8'))
option_fields={f.get('name'):f for f in settings['fields']}
defaults=json.loads((ROOT/'inc/data/content-defaults.json').read_text('utf8'))
sources='\n'.join(p.read_text('utf8') for pattern in ['*.php','inc/*.php','modules/*.php','template-parts/*.php','woocommerce/**/*.php','assets/js/*.js'] for p in ROOT.glob(pattern))
registry={}
for path in sorted((ROOT/'inc/data').glob('template-content*.json')):
    entries=json.loads(path.read_text('utf8'))
    if args.prune_unused:
        entries={key:value for key,value in entries.items() if ("'"+key+"'") in sources or ('"'+key+'"') in sources}
        path.write_text(json.dumps(entries,ensure_ascii=False,indent=4)+'\n',encoding='utf8')
    for key,value in entries.items():
        if key in registry:raise ValueError('Duplicate registry key: '+key)
        if not re.fullmatch('[a-z0-9_]+',key) or value['type'] not in ('text','icon','image'):raise ValueError(key)
        if value.get('module') and value['module'] not in layouts:raise ValueError('Unknown module: '+key)
        if not (ROOT/value['source']).is_file():raise ValueError('Unknown source: '+key)
        registry[key]=value

def section(source):
    if source in ('header.php','footer.php','inc/nav-walkers.php','inc/theme-setup.php'):return 'shared'
    if '/emails/' in source:return 'emails'
    if any('/'+part+'/' in source for part in ['cart','checkout','order']):return 'checkout'
    if source.startswith('woocommerce/') or 'product-reviews' in source:return 'storefront'
    if source.startswith('inc/'):return 'system'
    return 'pages'

def fields(key,entry):
    name='wc_'+key;kind=entry['type'];default=entry['default']
    field_type='image' if kind=='image' else ('wysiwyg' if kind=='text' and re.search(r'<[a-z]+[ >]',default) else ('textarea' if kind=='icon' or len(default)>100 else 'text'))
    field={'key':'field_'+name,'label':entry['label'],'name':name,'type':field_type,'required':0,'instructions':'Default is installed once into an empty field. Later edits and clears are preserved. Source: '+entry['source']}
    if kind=='image':field.update(return_format='id',preview_size='thumbnail',library='all')
    else:field.update(default_value=default,rows=4 if kind=='icon' else 3,new_lines='')
    if field_type=='wysiwyg':field.update(toolbar='basic',media_upload=0,tabs='all')
    result=[field]
    if kind=='icon':result.append({'key':'field_'+name+'_image','label':entry['label']+' custom image','name':name+'_image','type':'image','return_format':'id','preview_size':'thumbnail','instructions':'Optional Media Library image replacing this icon.'})
    return result

for layout_name,layout in layouts.items():
    layout['sub_fields']=[field for field in layout['sub_fields'] if not field.get('key','').startswith('field_wc_')]
    original={f.get('name'):f for f in layout['sub_fields']}
    for name,repeater in defaults['modules'].get(layout_name,{}).get('repeaters',{}).items():
        if name in original:
            original[name]['default_value']=[{repeater['subs'][sub]:value for sub,value in row.items() if sub in repeater['subs']} for row in repeater['rows']]
    extra=[]
    for key,entry in registry.items():
        if entry.get('module')!=layout_name:continue
        if entry.get('field_name'):
            target=original.get(entry['field_name'])
            if not target or target['key']!=entry['field_key']:raise ValueError('Missing original field: '+key)
        else:extra+=fields(key,entry)
    if extra:layout['sub_fields'] += [{'key':'field_wc_tab_'+layout_name,'name':'','label':'Additional text','type':'tab','placement':'top'}]+extra
module_path.write_text(json.dumps(module_group,ensure_ascii=False,indent=4)+'\n',encoding='utf8')

groups={}
for key,entry in registry.items():
    if entry.get('module'):continue
    if entry.get('field_name'):
        target=option_fields.get(entry['field_name'])
        if not target or target['key']!=entry['field_key']:raise ValueError('Missing original option: '+key)
        continue
    groups.setdefault(entry['source'],[]).extend(fields(key,entry))
generated=set()
for source,group_fields in groups.items():
    slug=re.sub('[^a-z0-9]+','_',source.lower()).strip('_')
    title=Path(source).stem.removeprefix('content-').replace('-',' ').replace('_',' ').title()
    if source.startswith('woocommerce/emails/'):title='Email: '+title.removeprefix('Email ')
    group={'key':'group_wc_'+slug,'title':title,'fields':group_fields,'location':[[{'param':'options_page','operator':'==','value':'waklert-content-'+section(source)}]],'menu_order':50,'position':'normal','style':'default','active':True,'description':'Generated template content fields. Source: '+source}
    path=ROOT/'acf-json'/('group_wc_'+slug+'.json');generated.add(path)
    path.write_text(json.dumps(group,ensure_ascii=False,indent=4)+'\n',encoding='utf8')
for path in (ROOT/'acf-json').glob('group_wc_*.json'):
    if path not in generated and json.loads(path.read_text('utf8')).get('key','').startswith('group_wc_'):path.unlink()
print(json.dumps({'content_entries':len(registry),'module_entries':sum(bool(v.get('module')) for v in registry.values()),'reused_fields':sum(bool(v.get('field_name')) for v in registry.values()),'shared_groups':len(groups)}))
