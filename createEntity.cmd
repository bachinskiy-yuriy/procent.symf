del /Q src\AppBundle\Resources\config\doctrine\*
del /Q src\AppBundle\Entity\*
php bin/console doctrine:mapping:import AppBundle
php bin/console doctrine:mapping:convert annotation ./src
php bin/console doctrine:generate:entities AppBundle
del /Q src\Appbundle\Resources\config\doctrine\*
