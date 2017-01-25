# $arr

###########################################################################################
### THIS MODULE IS SERIOUSLY FORKED... OR IT NEEDS TO BE, BECAUSE IT DOESN'T WORK RIGHT ###
###########################################################################################

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/'] }

# Activate our new theme
exec {'wp theme activate flo-theme-2017':
    command => "$wp_cli_sym theme activate flo-theme-2017",
    cwd => $site_dir,
    user => $site_user,
    require => Exec['wp core install'],
}