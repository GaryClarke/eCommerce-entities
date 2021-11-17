<?php

use Doctrine\ORM\EntityManager;

require_once 'vendor/autoload.php';

require_once 'bootstrap.php';

[$filename, $username, $password] = $argv;

$user = new \App\Entity\User();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$user->setUsername($username);
$user->setPassword($hashedPassword);

/** EntityManager $em */
$em = $entityManager;

$em->persist($user);
$em->flush();

echo 'Created user with id ' . $user->getId() . PHP_EOL;




