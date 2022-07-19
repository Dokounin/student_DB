<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use DateTimeImmutable;
use App\Entity\Project;
use App\Entity\Student;
use App\Entity\SchoolYear;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create("fr_FR");
        $this->loadSchoolYears($manager, $faker);
        $this->loadTags($manager, $faker);
        $this->loadStudents($manager, $faker);
        $this->loadProjects($manager, $faker);

    }
    public function loadSchoolYears(ObjectManager $manager, FakerGenerator $faker): void
    {
        $schoolYearDatas = [
            [
                'name' => 'Senior Factors Developer',
                'startdate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 09:00:00'),
                'enddate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-11-01 09:00:00'),
            ],
            [
                'name' => 'National Group Facilitator',
                'startdate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 08:00:00'),
                'enddate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-10-01 10:00:00'),

            ],
            [
                'name' => 'Global Research Orchestrator',
                'startdate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 07:00:00'),
                'enddate_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-09-01 11:00:00'),

            ],
        ];

        foreach ($schoolYearDatas as $schoolYearData) {
            $schoolYear = new SchoolYear();
            $schoolYear->setName($schoolYearData['name']);
            $schoolYear->setStartdateAt($schoolYearData['startdate_at']);
            $schoolYear->setEnddateAt($schoolYearData['enddate_at']);

            $manager->persist($schoolYear);
        }

        for ($i = 0; $i < 10; $i++) {

            $schoolYear = new SchoolYear();
            $schoolYear->setName($faker->words(3, true));

            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            // format : YYYY-mm-dd HH:ii:ss
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            // si la gestion de la date est trop compliquée, voici une alternative mais l'année changera en fonction de quand vous lancer le chargement des fixtures
            // $date = $faker->dateTimeThisYear();
            // $date = DateTimeImmutable::createFromInterface($date);
            $schoolYear->setStartdateAt($date);

            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            // format : YYYY-mm-dd HH:ii:ss
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            // si la gestion de la date est trop compliquée, voici une alternative mais l'année changera en fonction de quand vous lancer le chargement des fixtures
            // $date = $faker->dateTimeThisYear();
            // $date = DateTimeImmutable::createFromInterface($date);
            $schoolYear->setEnddateAt($date);

            $manager->persist($schoolYear);
        }

        $manager->flush();
    }

    public function loadStudents(ObjectManager $manager, FakerGenerator $faker): void
    {
        $repository = $this->doctrine->getRepository(SchoolYear::class);
        $schoolYears = $repository->findAll();

        $repository = $this->doctrine->getRepository(Tag::class);
        $tags = $repository->findAll();


        $studentDatas =
            [
                [
                    'Firstname' => 'Daishi',
                    'Lastname' => 'Johnston',
                    'schoolYear' => $schoolYears[0],
                    'tags' => [$tags[0], $tags[1]],
                ],
                [
                    'Firstname' => 'Philippe',
                    'Lastname' => 'Crona',
                    'schoolYear' => $schoolYears[1],
                    'tags' => [$tags[2],$tags[0]],
                ],
                [
                    'Firstname' => 'Baptiste',
                    'Lastname' => 'Raynor',
                    'schoolYear' => $schoolYears[2],
                    'tags' => [$tags[1],$tags[2]],
                ],

            ];
        foreach ($studentDatas as $studentData) {
            $student = new Student();
            $student->setFirstname($studentData['Firstname']);
            $student->setLastname($studentData['Lastname']);
            $student->setSuccess(null);
            $student->setSchoolYear($studentData['schoolYear']);

            foreach ($studentData['tags'] as $tag) {
                $student->addTag($tag);
            }

            $manager->persist($student);
        }

        
        for ($i = 0; $i < 100; $i++) {

            $student = new Student();
            $student->setFirstname($faker->word());
            $student->setLastname($faker->word());
            $student->setSuccess(null);
            $schoolYear = $faker->randomElements($schoolYears)[0];
            $student->setSchoolYear($schoolYear);

            $manager->persist($student);

            // génération d'un nombre aléatoire compris entre 0 et 4 inclus
            $count = random_int(0, 4);
            $studentTags = $faker->randomElements($tags, $count);

            foreach ($studentTags as $tag) {
                $student->addTag($tag);
            }

            $manager->persist($student);
        }
        $manager->flush();
    }

    public function loadProjects(ObjectManager $manager, FakerGenerator $faker): void
    {
        $projectDatas = [
            [
                'name' => 'Direct Quality Planner',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 09:00:00'),
                'ended_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-11-01 09:00:00'),
            ],
            [
                'name' => 'Human Communications Architect',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 08:00:00'),
                'ended_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-10-01 10:00:00'),



            ],
            [
                'name' => 'Global Usability Specialist',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 07:00:00'),
                'ended_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-09-01 11:00:00'),

            ],
        ];

        foreach ($projectDatas as $projectData) {
            $project = new Project();
            $project->setName($projectData['name']);
            $project->setStartedAt($projectData['started_at']);
            $project->setEndedAt($projectData['ended_at']);

            $manager->persist($project);
        }
        for ($i = 0; $i < 10; $i++) {

            $project = new Project();
            $project->setName($faker->words(3, true));

            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            // format : YYYY-mm-dd HH:ii:ss
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            // si la gestion de la date est trop compliquée, voici une alternative mais l'année changera en fonction de quand vous lancer le chargement des fixtures
            // $date = $faker->dateTimeThisYear();
            // $date = DateTimeImmutable::createFromInterface($date);
            $project->setStartedAt($date);

            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            // format : YYYY-mm-dd HH:ii:ss
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            // si la gestion de la date est trop compliquée, voici une alternative mais l'année changera en fonction de quand vous lancer le chargement des fixtures
            // $date = $faker->dateTimeThisYear();
            // $date = DateTimeImmutable::createFromInterface($date);
            $project->setEndedAt($date);

            $manager->persist($project);
        }

        $manager->flush();
    }

    public function loadTags(ObjectManager $manager, FakerGenerator $faker): void
    {
        $tagNames = [
            'HTML',
            'CSS',
            'PHP',
        ];
        // $faker -> word()
        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
        }
        for ($i = 0; $i < 10; $i++) {

            $tag = new Tag();
            $tag->setName("{$faker->word()}");
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
