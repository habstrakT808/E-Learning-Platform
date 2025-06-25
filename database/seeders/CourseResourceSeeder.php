<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseResource;
use App\Models\Course;

class CourseResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resourceTypes = ['document', 'book', 'video', 'link'];
        $fileTypes = ['pdf', 'docx', 'xlsx', 'pptx', 'mp4', 'zip'];
        
        $courses = Course::all();
        
        foreach ($courses as $course) {
            // Generate 3-7 resources for each course
            $resourceCount = rand(3, 7);
            
            for ($i = 0; $i < $resourceCount; $i++) {
                $type = $resourceTypes[array_rand($resourceTypes)];
                $isExternal = rand(0, 1) === 1;
                $fileType = $fileTypes[array_rand($fileTypes)];
                $fileSize = rand(500000, 15000000); // 500KB - 15MB
                
                CourseResource::create([
                    'course_id' => $course->id,
                    'title' => $this->generateTitle($type, $i, $course->title),
                    'description' => $this->generateDescription($type),
                    'type' => $type,
                    'url' => $isExternal ? "https://example.com/resources/{$course->id}/{$i}" : null,
                    'file_path' => !$isExternal ? "courses/{$course->id}/resources/resource_{$i}.{$fileType}" : null,
                    'file_size' => !$isExternal ? $fileSize : null,
                    'file_type' => !$isExternal ? strtoupper($fileType) : null,
                    'sort_order' => $i + 1,
                    'is_external' => $isExternal,
                ]);
            }
        }
    }
    
    private function generateTitle(string $type, int $index, string $courseTitle): string
    {
        $titles = [
            'document' => [
                'Assignment Exercise',
                'Practice Worksheet',
                'Cheatsheet for',
                'Summary Guide',
                'Reference Documentation',
                'Quick Start Guide',
            ],
            'book' => [
                'Recommended Reading:',
                'Textbook:',
                'E-book:',
                'Reference Manual:',
                'Handbook for',
            ],
            'video' => [
                'Tutorial Video:',
                'Supplemental Lecture:',
                'Demonstration of',
                'Case Study:',
                'Practical Example:',
            ],
            'link' => [
                'External Tool:',
                'Helpful Resource:',
                'Online Calculator for',
                'Interactive Demo:',
                'Documentation:',
            ],
        ];
        
        $typeSpecificTitles = $titles[$type] ?? $titles['document'];
        $titlePrefix = $typeSpecificTitles[array_rand($typeSpecificTitles)];
        
        $courseParts = explode(' ', $courseTitle);
        $courseShortName = count($courseParts) > 2 ? implode(' ', array_slice($courseParts, 0, 2)) : $courseTitle;
        
        return "{$titlePrefix} {$courseShortName} - Part " . ($index + 1);
    }
    
    private function generateDescription(string $type): string
    {
        $descriptions = [
            'document' => [
                'Comprehensive guide covering all aspects of this topic.',
                'Step-by-step instructions to complete the exercises.',
                'Reference material with examples and practical applications.',
                'Complete documentation with detailed explanations.',
                'Practice problems to test your knowledge.',
            ],
            'book' => [
                'Essential reading material that covers core concepts in depth.',
                'Comprehensive textbook with examples and case studies.',
                'Supplemental reading that provides additional context.',
                'Complete reference guide for all course topics.',
                'Advanced material for those wanting to explore further.',
            ],
            'video' => [
                'Visual demonstration of key concepts covered in the lecture.',
                'Step-by-step walkthrough of solving complex problems.',
                'Recorded presentation with additional examples not covered in class.',
                'Expert interview providing industry perspective on course topics.',
                'Practical demonstration of applying theoretical knowledge.',
            ],
            'link' => [
                'External resource that provides interactive tools for practice.',
                'Useful online utility for applying course concepts.',
                'Additional learning resource from a reputable source.',
                'Industry website with relevant examples and documentation.',
                'Official documentation for technologies covered in this course.',
            ],
        ];
        
        $typeDescriptions = $descriptions[$type] ?? $descriptions['document'];
        return $typeDescriptions[array_rand($typeDescriptions)];
    }
} 