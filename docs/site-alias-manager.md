Site Alias Manager
==================

The [Site Alias Manager (SAM)](https://github.com/consolidation/site-alias/blob/4.0.1/src/SiteAliasManager.php) service is used to retrieve information about one or all of the site aliases for the current installation.

- An informative example is the [browse command](https://github.com/drush-ops/drush/blob/13.x/src/Commands/core/BrowseCommands.php)
- A commandfile gets usually access to the SAM via [autowire](dependency-injection.md#autowire) of a dependency:
```php
#[Autowire(service: DependencyInjection::SITE_ALIAS_MANAGER)]
private readonly SiteAliasManagerInterface $siteAliasManager
```
- If an alias was used for the current request, it is available via `$this->siteAliasManager->getself()`.
- The SAM generally deals in [SiteAlias](https://github.com/consolidation/site-alias/blob/main/src/SiteAlias.php) objects. That is how any given site alias is represented. See its methods for determining things like whether the alias points to a local host or remote host.
- [Site alias docs](site-aliases.md).
- [Dynamically alter site aliases](https://raw.githubusercontent.com/drush-ops/drush/11.x/examples/Commands/SiteAliasAlterCommands.php).
- The SAM is also available for as [a standalone Composer project](https://github.com/consolidation/site-alias). More information available in the README there.
