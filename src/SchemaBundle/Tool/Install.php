<?php

namespace SchemaBundle\Tool;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Migrations\MigrationException;
use Doctrine\DBAL\Migrations\Version;
use Pimcore\Bundle\AdminBundle\Security\User\TokenStorageUserResolver;
use Pimcore\Extension\Bundle\Installer\MigrationInstaller;
use Pimcore\Migrations\Migration\InstallMigration;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class Install extends MigrationInstaller
{
    /**
     * @var TokenStorageUserResolver
     */
    protected $resolver;

    /**
     * @var DecoderInterface
     */
    protected $serializer;

    /**
     * @param TokenStorageUserResolver $resolver
     */
    public function setTokenStorageUserResolver(TokenStorageUserResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param DecoderInterface $serializer
     */
    public function setSerializer(DecoderInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion(): string
    {
        return '00000001';
    }

    /**
     * @throws MigrationException
     */
    protected function beforeInstallMigration()
    {
        $migrationConfiguration = $this->migrationManager->getBundleConfiguration($this->bundle);
        $this->migrationManager->markVersionAsMigrated($migrationConfiguration->getVersion($migrationConfiguration->getLatestVersion()));

        $this->initializeFreshSetup();
    }

    /**
     * @param Schema  $schema
     * @param Version $version
     */
    public function migrateInstall(Schema $schema, Version $version)
    {
        /** @var InstallMigration $migration */
        $migration = $version->getMigration();
        if ($migration->isDryRun()) {
            $this->outputWriter->write('<fg=cyan>DRY-RUN:</> Skipping installation');

            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function needsReloadAfterInstall()
    {
        return true;
    }

    public function initializeFreshSetup()
    {
        // currently nothing to do.
        return;
    }

    /**
     * @param Schema  $schema
     * @param Version $version
     */
    public function migrateUninstall(Schema $schema, Version $version)
    {
        /** @var InstallMigration $migration */
        $migration = $version->getMigration();
        if ($migration->isDryRun()) {
            $this->outputWriter->write('<fg=cyan>DRY-RUN:</> Skipping uninstallation');

            return;
        }

        // currently nothing to do.
    }

    /**
     * @param string|null $version
     */
    protected function beforeUpdateMigration(string $version = null)
    {
        // currently nothing to do.
        return;
    }
}
