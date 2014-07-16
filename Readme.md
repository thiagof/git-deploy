###Install

**Prepare the ssh-agent with a credential**

    # Generate a SSH public key
    ssh-keygen -t rsa -C "your_email@example.com" -f ~/.ssh/bitbucket
    ssh-add ~/.ssh/bitbucket

    # Config ssh to use the key
    nano ~/.ssh/config
    # With a snippet like this
    Host bitbucket-deploy
      HostName bitbucket.org
      IdentityFile ~/.ssh/bitbucket

Also check your server git user configuration

    git config --global user.name "Your Name"
    git config --global user.email you@example.com

**Configure git host to accept your certificates**

- Git Hub: https://help.github.com/articles/generating-ssh-keys#step-3-add-your-ssh-key-to-github
- Bitbucket (step 6): https://confluence.atlassian.com/pages/viewpage.action?pageId=270827678

**Init your project repository in the server**

    # Use the identity to initially load the repository
    git clone git@bitbucket-deploy/myself/projrepo.git

    # Checkout the repository to your desired branch
    cd projrepo
    git checkout develop
    git branch --set-upstream develop origin/develop

    # Init your modules
    git submodule init
    git submodule update

**Setup the git-deploy app**

    # Clone the app
    git clone https://github.com/thiagof/git-deploy

    # Configure your deployment project in git-deploy
    cd git-deploy
    nano deploy-config.php

**Configure Bitbucket or Github to hook into the deploy tool**

The deployment hook URI should be something like the above
    
    http://mywebsite.com/git-deploy/bitbucket.php?pkey=mysecret


And with this setup your project pushs will automatically get into your project website!


**Multiple projects on single git-deploy instance**

You need to configure the `$git_bin` variable in deploy-config.

    $git_bin = 'sudo /usr/bin/git';

This would allow your httpd user to pull changes on any folder, from another projects and sites for example. The trick is to configure sudoers file

    httpd_user    ALL = NOPASSWD: /usr/bin/git

###Todo

- Review github wrapper to replicate the new features added to the bitbucket wrapper
- Allow multiple $repos to be match - same repo on different locations
- Better handling of pull success (track problems)
- Refactor git-deploy front php and class