require 'deprec'
  
set :application, "sv-ide"
set :domain, "sv-ide.com"

# Update these if you're not running everything on one host.
role :app, domain
role :web, domain
role :db,  domain, :primary => true
role :scm, domain # used by deprec if you want to install subversion

# If you aren't deploying to /var/www/apps/#{application} on the target
# servers (which is the deprec default), you can specify the actual location
# via the :deploy_to variable:
set :deploy_to, "/opt/apps/#{application}"

# If you aren't using Subversion to manage your source code, specify
# your SCM below:
set :scm, :git
set :repository,  "git@github.com:drnic/sv-ide.git"

# set :ssh_options, { :forward_agent => true }

set :branch, "master"

# create a symlink to where I store all my images on
# the server.
desc 'Link to central uploads folder'
task :after_symlink do
  share = "#{deploy_to}/#{shared_dir}"
  current = "#{deploy_to}/#{current_dir}"
  run "ln -nfs #{share}/uploads/ #{current}/wp-content/uploads"

  configs = %w[ wp-config.php ]
  configs.each do |config|
    run "cp -f #{share}/config/#{config} #{current}/#{config}"
  end
  
  editable = %w[ wp-content/themes ]
  editable.each do |edit|
    # sudo "chown "
  end
end

# TODO - how to actually override these tasks.. doesn't seem to work
namespace :deprec do
  namespace :rails do
    # do nothing but overide the default 
    task(:symlink_shared_dirs, :roles => :app) { }
    task(:set_perms_for_mongrel_dirs, :roles => :app) { }
  end
end

namespace :deploy do
  # do nothing but overide the default 
  task(:restart, :roles => :app) {}
end

