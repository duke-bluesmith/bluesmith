#!/bin/sh

### post-update.sh for Composer
# Copies composer asset files from ./vendor to ./public

# setup asset directory
mkdir -pv public/assets

# disable directory access
cp -n app/index.html public/assets/

### Specific package handling

# JQuery
rm -rf public/assets/jquery
mkdir public/assets/jquery
cp vendor/components/jquery/jquery* public/assets/jquery/
cp -n app/index.html public/assets/jquery/

# Bootstrap
rm -rf public/assets/bootstrap
mkdir public/assets/bootstrap
cp -R vendor/twbs/bootstrap/dist/css/* public/assets/bootstrap/
cp -R vendor/twbs/bootstrap/dist/js/* public/assets/bootstrap/
cp -n app/index.html public/assets/bootstrap/

# Chart.js
rm -rf public/assets/chartjs
cp -R vendor/nnnick/chartjs/dist public/assets/chartjs
cp -n app/index.html public/assets/chartjs/

# Datatables
rm -rf public/assets/datatables
cp -R vendor/datatables/datatables/media public/assets/datatables
cp -n app/index.html public/assets/datatables/
cp vendor/peekleon/datatables-all/extensions/Buttons/css/* public/assets/datatables/css/
cp vendor/peekleon/datatables-all/extensions/Buttons/js/* public/assets/datatables/js/

# Dropzone.js
rm -rf public/assets/dropzone
mkdir public/assets/dropzone
cp vendor/enyo/dropzone/dist/min/* public/assets/dropzone
cp -n app/index.html public/assets/dropzone/

# FontAwesome
rm -rf public/assets/font-awesome
mkdir public/assets/font-awesome/
cp -R vendor/fortawesome/font-awesome/css public/assets/font-awesome/
cp -R vendor/fortawesome/font-awesome/webfonts public/assets/font-awesome/
cp -n app/index.html public/assets/font-awesome/
cp -n app/index.html public/assets/font-awesome/webfonts/

# SB Admin 2
rm -rf public/assets/sbadmin2
mkdir public/assets/sbadmin2
cp vendor/blackrockdigital/sb-admin-2/css/* public/assets/sbadmin2/
cp vendor/blackrockdigital/sb-admin-2/js/*.js public/assets/sbadmin2/
cp vendor/blackrockdigital/sb-admin-2/vendor/jquery-easing/*.js public/assets/jquery/
cp -n app/index.html public/assets/sbadmin2/
# also link out to public for sample views
rm -f public/sbadmin2
ln -s ../vendor/blackrockdigital/sb-admin-2 public/sbadmin2


### All done

exit 0
