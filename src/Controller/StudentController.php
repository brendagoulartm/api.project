<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'get_all_students')]
    public function index(StudentRepository $studentRepository): JsonResponse
    {
        $students = $studentRepository->findAll();
        return $this->json($students);
    }

    #[Route('/new', name: 'new_student')]
    public function new(EntityManagerInterface $em)
    {
        $student = new Student();
        $student->setName("Brenda");
        $student->setAge(19);
        
        $em->persist($student); 
        $em->flush(); 
        return $this->json("student saved");  
    }

    #[Route('/delete/{id}', name: 'delete_student', methods:["DELETE", "GET"])]
    public function delete(EntityManagerInterface $em, int $id)
    {
        $studentRepository = $em->getRepository(Student::class);
        $student = $studentRepository->find($id);
        $em->remove($student);
        $em->flush();
        return $this->json("student removed");  
        
    }
}
