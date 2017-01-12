$wp_cli_path = '/usr/local/src/wp-cli'
$site_user = 'serverpilot'
$site_dir = '/srv/users/serverpilot/apps/wordpress/public'
$site_url = 'flo.dev'
$site_name = 'Focused Labs Oils'
$rewrite = '/blog/%postname%/'
$time_zone = 'US/Mountain'
$app_ver = 'sp-php7.0'

###########################################################################################
### THIS MODULE IS SERIOUSLY FORKED... OR IT NEEDS TO BE, BECAUSE IT DOESN'T WORK RIGHT ###
###########################################################################################

# Make sure the ServerPilot installer is done and NGINX is running
exec {"wait for nginx":
  require => Service["nginx-sp"],
  command => "/usr/bin/wget --spider --tries 30 --retry-connrefused --no-check-certificate http://localhost:80/",
}

# Create the install path
file { [ "$wp_cli_path", "$wp_cli_path/bin" ]:
    ensure => directory,
}

# Clone the Git repo
exec{ 'wp-cli download':
    command => "/usr/bin/curl -o $wp_cli_path/bin/wp -L https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar",
    require => [ Exec[ 'wait for nginx' ], File[ $wp_cli_path ] ],
    creates => "$wp_cli_path/bin/wp"
}

# Ensure we can run wp-cli
file { "$wp_cli_path/bin/wp":
    ensure => "present",
    mode => "a+x",
    require => Exec[ 'wp-cli download' ]
}

# Symlink it across
file { '/usr/bin/wp':
    ensure => link,
    target => "$wp_cli_path/bin/wp",
    require => File[ "$wp_cli_path/bin/wp" ],
}

# Change the cli_path variable
$wp_cli_path = '/usr/bin/wp'

exec {'wp core download':
    command => "$wp_cli_path core download",
    cwd => $site_dir,
    user => $site_user,
    require => [ Class['wp::cli'] ],
    unless => "$wp_cli_path core is-installed"
}

# Generate a WP Config File
# Need to convert these to variables
exec {'wp core config':
    command => "$wp_cli_path core config --dbhost=localhost --dbname=flo-db --dbprefix= --dbuser=flo-wp-admin --dbpass='Xw#659Z{_w!2r*Hp'",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core download'],
    unless => "$wp_cli_path core is-installed"
}

# Setup the site
exec {'wp core install':
    command => "$wp_cli_path core install --url=http://$site_url --title=$site_name --admin_user=josh --admin_password='gorillamafia' --admin_email=josh@thaw.io",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core config'],
    unless => "$wp_cli_path core is-installed"
}

# Rewrite Permalinks
exec {'wp rewrite structure':
    command => "$wp_cli_path rewrite structure $rewrite",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Set the options to their required values
exec {'wp option update timezone_string':
    command => "$wp_cli_path option update timezone_string $time_zone",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Disable core auto-updates
exec {'wp option delete update_core':
    command => "$wp_cli_path option delete update_core",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}

# Setup themes and plugins
# wp::theme {'twentyseventeen':
#     location => $wplocation,
#     require => Wp::Site['store'],
# }

# wp::plugin {'woocommerce':
#     # ensure => enabled,
#     location => '/vagrant/wp',
#     require => Wp::Site['store'],
# }

# wp::plugin {'debug-bar':
#     ensure => installed,
#     location => '/vagrant/wp',
#     require => Wp::Site['store'],
# }
