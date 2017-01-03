# Development readme

- Use GitHub only, no direct pushing to Acquia.
  https://github.com/salsadigitalauorg/anzacatt
- Every feature must follow GitHub pull request, no direct merges
  into master or develop branch.
  
## Vagrant boxes

The Vagrantbox uses a lightweight build from https://github.com/beetboxvm/beetbox
repository. It uses VM Clones to save HDD space when multiple VMs are provisioned.

No actions required to download or to maintain the Vagrant box.

1. The repo has Vagrantfile included. Just navigate to the project root folder 
and execute `vagrant up`
2. When your Vagrant Box completes provisioning, copy file /local.config.yml 
into .beetbox/local.config.yml and change values as required.
3. After step to, re-run provisioning `vagrant provision`

NOTE! Do not modify the Vagrantfile.

## Local settings.php file
The local.settings.php file is locate in sites/default/ directory. If vagrant
box bundled to this project is used, no modifications are necessary.
