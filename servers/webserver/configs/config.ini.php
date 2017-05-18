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
debug								=true

[server]
path_root							=.
path_frameworks						=frameworks
path_api							=server/api/
path_pages							=server/content/views/
enable_page_cache					=true
path_page_cache						=server/cache/page_cache/
path_components						=server/content/components/
ext_page							=page
ext_component						=component
autoload_exclude[]					=api
autoload_exclude[]					=content
autoload_exclude[]					=pages
autoload_exclude[]					=config
autoload_exclude[]					=public

; Twig templating engine related settings.
[twig]
path_root							=server/content/				; Possibly obselete.
path_cache							=server/content/cache/
path_filesystem[path_layouts]		=server/content/layouts/
path_filesystem[path_templates]		=server/content/templates/
path_filesystem[path_content]		=server/content/content/
path_filesystem[path_macros]		=server/content/macros/
path_filesystem[path_common]		=server/content/common/
path_filesystem[path_components]	=server/content/components/
ext_twig							=twig

; Client side configs
[client]
path_assets							=/lora/assets/
path_paths[path_public_pages]		=/lora/
path_paths[path_public_styles]		=/lora/assets/styles/
path_paths[path_public_ext]			=/lora/assets/ext/
path_paths[path_public_images]		=/lora/assets/imgs/
path_paths[path_public_scripts]		=/lora/assets/scripts/
path_ws_server						=localhost
