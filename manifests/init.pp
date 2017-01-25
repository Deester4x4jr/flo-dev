group { 'puppet':
  ensure => present
}

Exec { path => [ '/bin/', '/sbin/', '/usr/bin/', '/usr/sbin/'] }
File { owner => 0, group => 0, mode => 0644 }

class { 'apt':
  update => {
    frequency => 'always',
  },
}

class pkg-setup {
    
  package { 'ca-certificates':
    ensure => 'installed'
  }
}

class config-ruby {

  class { '::ruby':
    gems_version => 'latest',
  }

  class { '::ruby::dev':
    ensure => 'installed',
  }

  package { 'ServerPilot':
    ensure   => 'installed',
    provider => 'gem',
    require => [ Class['::ruby'], Class['::ruby::dev'] ],
  }

  package { 'colorize':
    ensure   => 'installed',
    provider => 'gem',
    require => [ Class['::ruby'], Class['::ruby::dev'] ],
  }
}

class serverpilot {

  exec { 'run-serverpilot-script':
    command => 'ruby /home/vagrant/shared/serverpilot/serverpilot-provision-script.rb',
    refreshonly => true,
    subscribe => Package['ServerPilot'],
    require => Class['config-ruby'],
  }
}


include pkg-setup
include config-ruby
include serverpilot


notice "--------------------------------------------"
notice "|          We are doing shit here          |"
notice "--------------------------------------------"
