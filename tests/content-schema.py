"""Check registry/schema consistency without loading WordPress or changing data."""
import json,re
from pathlib import Path
ROOT=Path(__file__).resolve().parents[1]
registry={}
for path in (ROOT/'inc/data').glob('template-content*.json'):
    for key,value in json.loads(path.read_text('utf8')).items():
        assert key not in registry,('Duplicate registry key',key)
        registry[key]=value
fields={};duplicates=[]
def visit(value):
    if isinstance(value,dict):
        if str(value.get('key','')).startswith('field_'):
            key=value['key']
            if key in fields:duplicates.append(key)
            fields[key]=value
        for item in value.values():visit(item)
    elif isinstance(value,list):
        for item in value:visit(item)
for path in (ROOT/'acf-json').glob('*.json'):
    group=json.loads(path.read_text('utf8'))
    if group.get('active',True):visit(group)
assert not duplicates,('Duplicate ACF field keys',duplicates)
for key,entry in registry.items():
    field_key=entry.get('field_key','field_wc_'+key)
    assert field_key in fields,('Missing field',key,field_key)
    if entry['type']=='icon':assert 'field_wc_'+key+'_image' in fields,('Missing icon image override',key)
    assert not (entry['type']=='text' and re.match(r'^\s*[\"\']\s*(?:[\w-]+=|$)',entry['default'])),('Markup fragment registered as text',key)
sources=[p for pattern in ['*.php','inc/*.php','modules/*.php','template-parts/*.php','woocommerce/**/*.php'] for p in ROOT.glob(pattern)]
for path in sources:
    if path.name=='template-content.php':continue
    text=path.read_text('utf8')
    for key in re.findall(r"waklert_content(?:_icon_class|_icon|_asset)?\(\s*'([^']+)'",text):
        assert key in registry,('Unknown content reference',str(path),key)
assert 'data:image/svg+xml' not in (ROOT/'assets/css/source.css').read_text('utf8'), 'Fixed CSS icon remains.'
print(f'{len(registry)} content entries and {len(fields)} unique ACF fields verified.')
