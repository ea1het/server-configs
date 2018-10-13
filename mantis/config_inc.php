<?php
#
# MantisBT - a php based bugtracking system
#

# --- Database Configuration ---
$g_hostname = '';
$g_db_type = '';
$g_database_name = '';
$g_db_username = '';
$g_db_password = '';

# --- Anonymous Access / Signup ---
$g_allow_signup			= OFF;
$g_allow_anonymous_login	= OFF;
$g_anonymous_account		= '';

# --- Email Configuration ---
$g_phpMailer_method		= PHPMAILER_METHOD_SMTP; 			# or PHPMAILER_METHOD_MAIL, PHPMAILER_METHOD_SENDMAIL
$g_smtp_host			= '';		# used with PHPMAILER_METHOD_SMTP
$g_smtp_username		= '';		# used with PHPMAILER_METHOD_SMTP
$g_smtp_password		= '';		# used with PHPMAILER_METHOD_SMTP
$g_administrator_email  	= '';
$g_webmaster_email      	= '';
$g_from_email           	= '';		# the "From: " field in emails
$g_return_path_email    	= '';		# the return address for bounced mail
$g_from_name			= ‘’;
$g_email_receive_own		= OFF;
$g_email_send_using_cronjob 	= OFF;

# --- Attachments / File Uploads ---
$g_allow_file_upload	= ON;
$g_file_upload_method	= DISK; # or DATABASE
$g_absolute_path_default_upload_folder = '/opt/mantis-attach/'; # used with DISK, must contain trailing \ or /.
$g_max_file_size		= 5000000;	# in bytes
$g_preview_attachments_inline_max_size = 256 * 1024;
$g_preview_text_extensions 	= array( '', 'rsc', 'txt', 'diff', 'patch' );
$g_preview_image_extensions 	= array( 'bmp', 'png', 'gif', 'jpg', 'jpeg' );
$g_allowed_files		= 'txt,rsc,diff,patch,zip,rar,tar,gz,tgz,pdf,rtf,doc,docx,xls,xlsx,bmp,png,jpg,jpeg,gif';
$g_disallowed_files		= 'exe,scr,dll,bat,pif';

# --- Branding ---
$g_window_title			= '';
$g_logo_image			= 'images/logo.png';
$g_favicon_image		= 'images/favicon.ico';

# --- Real names ---
# $g_show_realname 		= OFF;
# $g_show_user_realname_threshold = NOBODY;	# Set to access level (e.g. VIEWER, REPORTER, DEVELOPER, MANAGER, etc)

# --- Others ---
$g_default_home_page 		= 'my_view_page.php';	# Set to name of page to go to after login
$g_hide_status_default 		= META_FILTER_NONE;
$g_status_enum_string 		= '10:new,20:feedback,30:acknowledged,50:assigned,80:resolved,90:closed';

$g_language_choices_arr		= array('auto','english','spanish');
$g_language_auto_map 		= array('en-us, en-gb, en-au, en' => 'english','es-mx, es-co, es-ar, es-cl, es-pr, es' => 'spanish');

$g_severity_multipliers 	= array( FEATURE => 1,
	                                 TRIVIAL => 2,
	                                 TEXT    => 3,
	                                 TWEAK   => 2,
	                                 MINOR   => 5,
	                                 MAJOR   => 8,
	                                 CRASH   => 8,
	                                 BLOCK   => 10 );


$g_severity_enum_string		= '10:feature,40:tweak,50:minor,60:major,70:crash,80:block';

$g_wiki_engine = '';
$g_wiki_root_namespace = 'mantis';
$g_wiki_engine_url = $t_protocol . '://' . $t_host . '/%wiki_engine%/';


$g_time_tracking_enabled = ON;


