Vagrant.configure(2) do |config|

    config.vm.define "gerald" do |gerald|
        # Base template for virtualbox, we use ubuntu 16.04 here
        gerald.vm.box = "ubuntu/xenial64"
        # Domain on which our application will respond later on
        gerald.vm.hostname  = "gerald.dev"
        # IP address will be used by the VM
        gerald.vm.network :private_network, ip: "192.168.21.12"

        # Tell vagrant to run ansible as a provisioner
        gerald.vm.provision :ansible do |ansible|
            # where the playbook is located
            ansible.playbook = "ansible/playbook.yml"
        end
    end

    # Access the shared vagrant directory via NFS, otherwise slow on mac and windows
    config.vm.synced_folder ".", "/var/www/gerald", type: "nfs"

    config.vm.provider "virtualbox" do |v|
        # tell virtualbox to give our machine 1 GB RAM and 2 Cores
        v.memory = 1024
        v.cpus = 2
    end
end

