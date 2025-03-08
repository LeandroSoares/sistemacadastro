<?php

namespace App\Traits;

trait CalculatesCompletion
{
    public function calculateCompletion(array $fieldConfigs): int
    {
        $totalWeight = 0;
        $completedWeight = 0;

        foreach ($fieldConfigs as $field => $weight) {
            $totalWeight += $weight;
            
            if ($this->isFieldComplete($field)) {
                $completedWeight += $weight;
            }
        }

        return $totalWeight > 0 ? round(($completedWeight / $totalWeight) * 100) : 0;
    }

    protected function isFieldComplete(string $field): bool
    {
        $value = $this->$field;
        
        if (is_string($value)) {
            return trim($value) !== '';
        }
        
        if (is_numeric($value)) {
            return true;
        }
        
        return !empty($value);
    }
}
