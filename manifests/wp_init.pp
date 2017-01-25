$home_dir = '/home/vagrant/shared'
$wp_cli_path = '/usr/local/src/wp-cli'
$wp_cli_sym = '/usr/bin/wp'
$site_user = 'serverpilot'
$site_dir = '/srv/users/serverpilot/apps/wordpress/public'
$site_url = 'flo.dev'
$site_name = 'Focused Labs Oils'
$rewrite = '/blog/%postname%/'
$time_zone = 'US/Mountain'
$app_ver = 'sp-php7.0'
$extra_php = "define( 'WP_AUTO_UPDATE_CORE', false );"
$plugins = ['amp','w3-total-cache',"$home_dir/wordpress/plugins/advanced-custom-fields-pro.zip",'login-lockdown','accelerated-mobile-pages','wordpress-seo','disable-comments','redirection','wordfence','google-analyticator','feed-them-social']
# Add logic for plugin install + remove options

###########################################################################################
### THIS MODULE IS SERIOUSLY FORKED... OR IT NEEDS TO BE, BECAUSE IT DOESN'T WORK RIGHT ###
###########################################################################################

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/', ''] }

# Make sure the ServerPilot installer is done and NGINX is running
exec {"wait for nginx":
  # require => Service["nginx-sp"],
  command => "wget --spider --retry-connrefused --waitretry=10 -t 30 --no-check-certificate http://localhost:80/index.php",
  # command => "nginx=`sudo lsof -i -n -P | grep nginx | wc -l`; while [ $nginx -lt 1 ]; do nginx=`sudo lsof -i -n -P | grep nginx | wc -l`; echo 'Nginx is down...'; sleep 10; done",
}

# Create the install path
file { [ "$wp_cli_path", "$wp_cli_path/bin" ]:
    ensure => directory,
}

# Clone the Git repo
exec {'wp-cli download':
    # command => "/usr/bin/curl -o $wp_cli_path/bin/wp -L https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar",
    command => "curl -o $wp_cli_path/bin/wp -L https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar",
    require => [ Exec[ 'wait for nginx' ], File[ $wp_cli_path ] ],
    creates => "$wp_cli_path/bin/wp"
}

# Ensure we can run wp-cli
file {"$wp_cli_path/bin/wp":
    ensure => "present",
    mode => "a+x",
    require => Exec[ 'wp-cli download' ]
}

# Symlink it across
file {"$wp_cli_sym":
    ensure => link,
    target => "$wp_cli_path/bin/wp",
    require => File[ "$wp_cli_path/bin/wp" ],
}

# Download WP Core (Latest)
exec {'wp core download':
    command => "wp core download",
    cwd => $site_dir,
    user => $site_user,
    require => [ File["$wp_cli_sym"] ],
    unless => "$wp_cli_sym core is-installed"
}

# Generate a WP Config File
# Need to convert these to variables
exec {'wp core config':
    command => "$wp_cli_sym core config --dbhost=localhost --dbname=flo-db --dbprefix=wp_ --dbuser=flo-wp-admin --dbpass='Xw#659Z{_w!2r*Hp' --extra-php <<PHP\n${extra_php}\nPHP",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core download'],
    unless => "$wp_cli_sym core is-installed"
}

# Setup the site
exec {'wp core install':
    command => "$wp_cli_sym core install --url=http://$site_url --title='${site_name}' --admin_user=josh --admin_password='gorillamafia' --admin_email=josh@thaw.io",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core config'],
    unless => "$wp_cli_sym core is-installed"
}

# Rewrite Permalinks
exec {'wp rewrite structure':
    command => "$wp_cli_sym rewrite structure $rewrite",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Set the options to their required values
exec {'wp option timezone_string':
    command => "$wp_cli_sym option update timezone_string $time_zone",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Disable core auto-updates
exec {'wp option update_core':
    command => "$wp_cli_sym option update update_core false",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Create a symlink to the theme files
file {'flo-theme-2017':
    path => '/srv/users/serverpilot/apps/wordpress/public/wp-content/themes/flo-theme-2017',
    ensure => 'link',
    target => '/tmp/app/theme',
    require => Exec['wp core install']
}

# Activate our new theme
exec {'wp theme activate flo-theme-2017':
    command => "$wp_cli_sym theme activate flo-theme-2017",
    cwd => $site_dir,
    user => $site_user,
    require => File['flo-theme-2017'],
}

# Install required plugins
define plugins {
    exec {"wp plugin install ${title}":
        command => "$wp_cli_sym plugin install ${title} --activate",
        cwd => $site_dir,
        user => $site_user,
        require => Exec['wp core install'],
    }
}
plugins { $plugins: }