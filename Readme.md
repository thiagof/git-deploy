###Install

Prepare the ssh-agent

    # Generate a SSH public key
    ssh-keygen -t rsa -C "your_email@example.com" -f ~/.ssh/bitbucket
    ssh-add ~/.ssh/bitbucket

    # Config ssh to use the key
    nano ~/.ssh/config
    # With a snippet like this
    Host bitbucket-deploy
      HostName bitbucket.org
      IdentityFile ~/.ssh/bitbucket

Start your project repository

    # Use the identity to initially load the repository
    git clone git@bitbucket-deploy/myself/projrepo.git

    # Checkout the repository to your desired branch
    cd projrepo
    git checkout develop
    git branch --set-upstream develop origin/develop

    # Init your modules
    git submodule init
    git submodule update

Setup the git-deploy app

    # Clone the app
    git clone 

    # Configure your deployment project in git-deploy
    cd git-deploy
    nano deploy-config.php

Finally configure Bitbucket or Github to access the deploy tool

- Git Hub: https://help.github.com/articles/generating-ssh-keys#step-3-add-your-ssh-key-to-github
- Bitbucket (step 6): https://confluence.atlassian.com/pages/viewpage.action?pageId=270827678

The deployment hook URI should be something like the above
    
    http://mywebsite.com/git-deploy/bitbucket.php?pkey=mysecret


And with this setup your project pushs will automatically get into your project website!


Ah, remember to allways configure your git account in the development env

    git config --global user.name "Your Name"
    git config --global user.email you@example.com



###Todo

- Review github wrapper to replicate the new features added to the bitbucket wrapper
- Allow multiple $repos to be match - same repo on different locations
- Better handling of pull success (track problems)