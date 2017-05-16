; <?php @ob_end_clean (); die (); ?>

;
;	Legend; indicator part will be removed from the config name. (server, path_root => server, root)
;	Valid indicators are path_ and ext_. Underscrore is required. See config.php for implementation details.
;	In order to these conveersions take effect, the configurations must be loaded using the Config class.
;	Due to architectural decision, multiple configurations can be loaded at once but the first to define 
;	a setting is the one to dictate its actual value.
;
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

; Twig templating engine related settings.
[twig]
path_root				=server/content/
path_cache				=server/content/cache/
path_layouts			=server/content/layouts/
path_templates			=server/content/templates/
path_content			=server/content/content/
path_macros				=server/content/macros/
path_common				=server/content/common/
path_components			=server/content/components/
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
