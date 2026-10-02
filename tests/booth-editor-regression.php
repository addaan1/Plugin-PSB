<?php
/** Run: php tests/booth-editor-regression.php /path/to/isolated-wordpress/wp-load.php
 * The isolated site's wp-config.php must define ASSIE4_TEST_ENVIRONMENT=true.
 */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) exit("Pass an isolated WordPress wp-load.php path.\n");
require $argv[1];
if ( ! defined('ASSIE4_TEST_ENVIRONMENT') || ! ASSIE4_TEST_ENVIRONMENT ) exit("Refusing to modify options outside an explicitly isolated test site.\n");
if ( ! function_exists('assie4_get_tenants') ) exit("Activate the pameran plugin in the test site first.\n");
$keys = [ASSIE4_OPT_INFO,ASSIE4_OPT_TICKER,ASSIE4_OPT_TENANTS,ASSIE4_OPT_RUNDOWN,ASSIE4_OPT_SLIDES,'assie4_directory_seed_state','assie4_content_format_version','assie4_local_tenant_logos_version','assie4_pameran_cache_ver'];
$backup = [];
foreach ( $keys as $key ) $backup[$key] = get_option($key,null);
$checks = 0;
function a4_check( $condition, $label ) {
    global $checks;
    if ( ! $condition ) throw new RuntimeException($label);
    $checks++;
}
try {
    $directory = assie4_presensi_booth_directory();
    foreach ( $directory as $number=>$booth ) a4_check(assie4_booth_location($booth['code'])['booth_no'] === $number, 'Map and presensi disagree: '.$booth['code']);
    a4_check(assie4_booth_location('H17') === null, 'Out-of-range code accepted');
    $tenant = assie4_normalize_tenant(['id'=>'d10','code'=>'D10','area'=>'D','name'=>"Tenant O'Brien",'desc'=>"\"Karya inovasi\"\nBaris kedua C:\\Data",'cat'=>'Startup','status_booth'=>'nonaktif','hari_operasi'=>['1']]);
    a4_check($tenant['status_booth']==='aktif' && $tenant['hari_operasi']===['1','2','3'], 'Operation is not automatic');
    update_option(ASSIE4_OPT_TENANTS,[$tenant],false);
    update_option('assie4_directory_seed_state','v3',false);
    update_option('assie4_local_tenant_logos_version','5',false);
    a4_check(count(assie4_get_tenants())===1 && assie4_get_tenants()[0]['name']==="Tenant O'Brien", 'Custom D10 was replaced by seed data');
    update_option(ASSIE4_OPT_TENANTS,[],false);
    a4_check(assie4_get_tenants()===[], 'Intentionally empty directory was repopulated');
    $legacy = $tenant;
    $legacy['desc'] = wp_slash($tenant['desc']);
    // Only quote escapes should be repaired; a genuine path backslash stays intact.
    $legacy['desc'] = str_replace('C:\\\\Data','C:\\Data',$legacy['desc']);
    update_option(ASSIE4_OPT_TENANTS,[$legacy],false);
    update_option(ASSIE4_OPT_RUNDOWN,['days'=>[['label'=>"**Jum\\'at, 6 November 2026**"]],'events'=>[]],false);
    update_option(ASSIE4_OPT_SLIDES,[['title'=>'ASSIE IV 2026']],false);
    delete_option('assie4_content_format_version');
    assie4_upgrade_stored_content();
    a4_check(assie4_get_tenants()[0]['desc']===$tenant['desc'], 'Legacy quote/newline repair changed description');
    a4_check(get_option(ASSIE4_OPT_RUNDOWN)['days'][0]['label']==='Jumat, 6 November 2026', 'Legacy Friday label is still malformed');
    a4_check(get_option(ASSIE4_OPT_SLIDES)[0]['title']==='IM ASSIE IV 2026', 'Existing event branding was not updated');
    a4_check(assie4_brand_text('IM ASSIE IV 2026')==='IM ASSIE IV 2026', 'Branding was applied twice');
    $reject = function($new,$old) { return $old; };
    add_filter('pre_update_option_'.ASSIE4_OPT_TENANTS,$reject,10,2);
    $changed = $tenant; $changed['name']='New name';
    $result = assie4_save_tenants([$changed]);
    remove_filter('pre_update_option_'.ASSIE4_OPT_TENANTS,$reject,10);
    a4_check(is_wp_error($result), 'Failed write reported as a successful save');
    a4_check(assie4_get_tenants()[0]['name']===$tenant['name'], 'Rejected write changed saved tenant');
    echo "PASS: $checks booth editor regression checks.\n";
} finally {
    foreach ( $backup as $key=>$value ) {
        if ( $value === null ) delete_option($key);
        else update_option($key,$value,false);
    }
}
