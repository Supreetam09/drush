<?php

declare(strict_types=1);

namespace Drush\Commands\pm;

use Drupal\Core\Extension\ThemeInstallerInterface;
use Drush\Attributes as CLI;
use Drush\Commands\AutowireTrait;
use Drush\Commands\DrushCommands;
use Drush\Utils\StringUtils;

final class ThemeCommands extends DrushCommands
{
    use AutowireTrait;

    const INSTALL = 'theme:install';
    const UNINSTALL = 'theme:uninstall';

    public function __construct(
        protected ThemeInstallerInterface $themeInstaller
    ) {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getThemeInstaller(): ThemeInstallerInterface
    {
        return $this->themeInstaller;
    }

    /**
     * Install one or more themes.
     */
    #[CLI\Command(name: self::INSTALL, aliases: ['thin', 'theme:enable', 'then', 'theme-enable'])]
    #[CLI\Argument(name: 'themes', description: 'A comma delimited list of themes.')]
    public function install(array $themes): void
    {
        $themes = StringUtils::csvToArray($themes);
        if (!$this->getThemeInstaller()->install($themes)) {
            throw new \Exception('Unable to install themes.');
        }
        $this->logger()->success(dt('Successfully installed theme: !list', ['!list' => implode(', ', $themes)]));
    }

    /**
     * Uninstall themes.
     */
    #[CLI\Command(name: self::UNINSTALL, aliases: ['theme:un', 'thun', 'theme-uninstall'])]
    #[CLI\Argument(name: 'themes', description: 'A comma delimited list of themes.')]
    public function uninstall(array $themes): void
    {
        $themes = StringUtils::csvToArray($themes);
        // The uninstall() method has no return value. Assume it succeeded, and
        // allow exceptions to bubble.
        $this->getThemeInstaller()->uninstall($themes);
        $this->logger()->success(dt('Successfully uninstalled theme: !list', ['!list' => implode(', ', $themes)]));
    }
}
