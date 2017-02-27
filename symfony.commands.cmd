// ������ ���-������� 
php app/console server:run

// �������� ������ ��������
php app/console router:debug

// ��� ��������� ������ �� ��������� ��������� �������� ������� ������� �� ������� ����� � �������� � phpmyadmin � ��� �� �������� �� ���� ������
// ��� ������� �����, �� ���� ����� ������� �� �������� ������, ������

// �������� ���
php app/console cache:clear --env=prod
php app/console cache:clear --env=dev



// ������� ���� ����� � ����������� � parameters.yml
// �� ������������ ���� ����������� � �������� latin
// ��� ��������� � UTF8 ��� � utf8mb4 ������� ���������� ���� ������������ mysql
// ��������� � ���� my.ini ��������� ��������� ��-������������:
// collation-server = utf8mb4_general_ci
// character-set-server = utf8mb4
php app/console doctrine:database:create

// �������� ���� �����
php app/console doctrine:database:drop --force

// ������� ����� � ������ AcmeTestBundle
php app/console generate:bundle --namespace=Acme/MobileBundle

// ������� ������ ����� ������� �� ��������� ����
php app/console doctrine:mapping:import A�meMobileBundle

// �������� ������/������ �� �����
php app/console doctrine:generate:entities AppBundle/Entity/Product

// �������� �������/������ �� ��� ����� � ����� Entities ������ AppBundle, ������� ������ �����
php app/console doctrine:generate:entities ACmeMobileBundle

// ������� ������� � �� �� ����� ����� � ����� Entity
php app/console doctrine:schema:update --force

// �������� �������� ������� � xml|yml � ��������
php app/console doctrine:mapping:convert annotation ./src

// doctrine ����������� ����� ���� ��� �������. ���������� �������� ����� ��� �� ��������.
// ����� ���� ������������� ��������, ���������� �������� xml|yml
// ��� ��������� ���������� � �����-����� �������� ���������:
// - �������� ����� ��� ��� ������� php app/console doctrine:mapping:import AppBundle
// - �������� ���� ����� ��� ��� ������� php app/console doctrine:generate:entities AppBundle
// - ������������ ����� � �������� php bin/console doctrine:mapping:convert annotation ./src
// - �������� ����� xml|yml ����������
// - �������� � �������� ���� �������� @ORM\Entity(repositoryClass="AppBundle\Entity\ArticlesRepository")
// - �������� �������� ���� ����� php app/console doctrine:generate:entities AppBundle

