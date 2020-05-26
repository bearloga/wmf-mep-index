# Modern Event Platform Schema Index (Flattened)

## Setup

```bash
sudo su
# remove the existing directory, replace with this repo:
rm -rf /var/www/html
git clone --recurse-submodules https://github.com/bearloga/wmf-mep-index /var/www/html
```

The `--recurse-submodules` is required because the schema repositories from Gerrit are set up as submodules.

### Updating

On dev side:

```bash
git submodule foreach git pull origin master
git add -A
git commit -m "Update submodules to latest commits"
git push
```

On prod side:

```bash
sudo su
git pull origin master
git submodule update
```

### CloudVPS

Make a new instance (e.g. `mep-schemas-flat-01`) and add [`role::simplelap`](https://github.com/wikimedia/puppet/blob/production/modules/role/manifests/simplelap.pp) (instead of [`role::simplelamp2`](https://gerrit.wikimedia.org/r/plugins/gitiles/operations/puppet/+/production/modules/role/manifests/simplelamp2.pp), which includes MariaDB) in Puppet config for the instance in [Horizon](https://horizon.wikimedia.org/)

SSH to `mep-schemas-flat-01.eqiad.wmflabs` and run `sudo puppet agent -t` to provision the instance with the `simplelamp2` role.

Set up proxy (e.g. [mep-index.wmflabs.org](https://mep-index.wmflabs.org/)) in Horizon:

| Hostname | Domain | Backend instance | Backend port |
|:---------|:-------|:-----------------|-------------:|
| `mep-index` | `wmflabs.org` | `mep-schemas-flat-01` | 80 |

### User dirs

The easiest thing to do is to work outside /var/www/html by enabling user directories via:

```bash
mkdir ~/public_html
touch ~/public_html/index.html
sudo a2enmod userdir
sudo systemctl restart apache2
```

Then [mep-index.wmflabs.org/~bearloga/](https://mep-index.wmflabs.org/~bearloga/) (for example) should be accessible.

#### PHP

After applying the role, if you get an error message like this while provisioning:

```
Notice: The LDAP client stack for this host is: sssd/sudo
Notice: /Stage[main]/Profile::Ldap::Client::Labs/Notify[LDAP client stack]/message: defined 'message' as 'The LDAP client stack for this host is: sssd/sudo'
Notice: /Stage[main]/Packages::Php_cli/Package[php-cli]/ensure: created
Notice: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: ERROR: Module mpm_event is enabled - cannot proceed due to conflicts. It needs to be disabled first!
Notice: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: ERROR: Could not enable dependency mpm_prefork for php7.3, aborting
Notice: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: Considering dependency mpm_prefork for php7.3:
Notice: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: Considering conflict mpm_event for mpm_prefork:
Notice: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: Considering conflict mpm_worker for mpm_prefork:
Error: '/usr/sbin/a2enmod php7.3' returned 1 instead of one of [0]
Error: /Stage[main]/Httpd/Httpd::Mod_conf[php7.3]/Exec[ensure_present_mod_php7.3]/returns: change from 'notrun' to ['0'] failed: '/usr/sbin/a2enmod php7.3' returned 1 instead of one of [0]
Notice: /Stage[main]/Httpd/Service[apache2]: Dependency Exec[ensure_present_mod_php7.3] has failures: true
```

Run these commands to fix:

```bash
sudo a2dismod mpm_event
sudo a2enmod php7.3
sudo systemctl restart apache2
```

**Note**: for local development on macOS, `sudo nano /etc/apache2/httpd.conf` and uncomment the following line (number 187 or so):

```
LoadModule php7_module libexec/apache2/libphp7.so
```

and restart the service via `sudo apachectl restart`
