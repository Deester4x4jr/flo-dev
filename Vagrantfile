# -*- mode: ruby -*-
# vi: set ft=ruby :
VAGRANTFILE_API_VERSION = "2"

# ServerPilot API Credentials
# CLIENT_ID = "cid_PPdOrmNPimLw7aFZ"
# API_KEY = "yoG3S3I2gpR26BkfBtcvUq7vQu5pK8bw8RHy0q9Byo8"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "bento/ubuntu-16.04"
  config.vm.network "private_network", ip: "192.168.11.14"

  # Here we set a custom hostname (requires vagrant-hostsupdater)
  config.vm.hostname = 'flo.dev'

  # Optionally, set a custom port for using the same hostname for multiple dev configs
  # config.vm.network 'forwarded_port', guest: 80, host: 5000, auto_correct: true

  config.vm.synced_folder "./app", "/tmp/app/", create: true, id: "theme-files"
  config.vm.synced_folder "./shared", "/home/vagrant/shared"

  # VM Config options
  config.vm.provider 'virtualbox' do |v|
    v.name = 'FLO Dev Box'
    v.customize ['modifyvm', :id, '--memory', '512', '--cpus', '1']
    v.customize ['modifyvm', :id, '--cableconnected1', 'on']
  end

  # config.vm.provider :digital_ocean do |provider, override|
  #   override.ssh.private_key_path = '~/.ssh/id_rsa'
  #   override.vm.box_url = 'https://github.com/smdahlen/vagrant-digitalocean/raw/master/box/digital_ocean.box'

  #   provider.client_id = 'YOUR_DIGITALOCEAN_CLIENT_ID'
  #   provider.api_key = 'YOUR_DIGITALOCEAN_API_KEY'

  #   provider.image = 'Ubuntu 12.04.3 x64'
  #   provider.region = 'New York 2'
  #   provider.size = '512MB'
  # end

  config.vm.provision :shell,
    inline: "sudo apt-get update -y && sudo apt-get install puppet -y"

  # config.vm.provision :shell,
  #   inline: "sudo usermod -a -G www-data vagrant"

  # config.vm.provision :shell,
  #   inline: "sudo chown -R vagrant:www-data /home/vagrant && sudo chmod -R g+w /home/vagrant && sudo chmod g+s /home/vagrant"

  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "manifests"
    puppet.manifest_file  = "wordpress_kickstart.pp"

    puppet.module_path = "./modules"
    puppet.options = "--verbose"
  end
end
