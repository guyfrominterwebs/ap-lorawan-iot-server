; <?php @ob_end_clean (); die (); ?>

;
; Legend; indicator part will be removed.
;	- path				Can be found with path -method using correct section and variable name.
;						All paths must be relative to main.php which is located in the local server root.
;	- extension			Can be found with ext -method using correct section and variable name.
;

[system]
debug					=true

[server]
path_root				=.
path_frameworks			=frameworks
path_api				=server/api
path_content			=server/content
path_pages				=server/content
enable_page_cache		=false
path_page_cache			=server/content/page_cache/
path_components			=server/content/components/
ext_page				=page
ext_component			=component
autoload_exclude[]		=api
autoload_exclude[]		=content
autoload_exclude[]		=pages
autoload_exclude[]		=config
autoload_exclude[]		=public

; 
[twig]
path_root				=server/content/
path_cache				=server/content/cache/
path_layouts			=server/content/layouts/
path_templates			=server/content/templates/
path_content			=server/content/content/
path_macros				=server/content/macros/
path_common				=server/content/common/
ext_twig				=twig

; Client side configs
[client]
path_pages				=/lora/
path_assets				=/lora/assets/
path_styles				=/lora/assets/styles/
path_ext				=/lora/assets/ext/
path_images				=/lora/assets/imgs/
path_scripts			=/lora/assets/scripts/
path_ws_server			=localhost
