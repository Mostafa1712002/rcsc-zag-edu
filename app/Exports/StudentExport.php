<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings, WithMapping{
    public $records;
    public function __construct($records){
        $this->records = $records;
    }

    public function collection(){
        return $this->records;
    }

    public function headings(): array{
        return [
            '#',
            'Full name',
            'Join date',
            'National ID',
            'Exam date',
            'Exam degree',
            'Exam grade'
        ];
    }

    public function map($record): array{

        return [
            $record->id,
            $record->full_name,
            $record->created_at,
            $record->national_id,
            $record->exam_at,
            $record->exam_degree,
            __('grades.'.$record->exam_grade)


        ];
    }
}
