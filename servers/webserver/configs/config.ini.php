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
path_pages				=pages
path_page_cache			=pages/page_cache/
ext_page				=page
autoload_exclude[]		=api
autoload_exclude[]		=content
autoload_exclude[]		=pages
autoload_exclude[]		=config
autoload_exclude[]		=public

; 
[twig]
path_cache				=pages/cache/
path_layouts			=pages/layouts/
path_templates			=pages/templates/
path_content			=pages/content/
path_macros				=pages/macros/
ext_twig				=twig

; Client side configs
[client]
path_pages				=/lora/
path_assets				=assets/
path_styles				=assets/styles/
path_ext				=assets/ext/
path_scripts			=assets/scripts/
path_ws_server			=localhost
