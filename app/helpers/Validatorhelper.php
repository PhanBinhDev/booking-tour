<?php
namespace App\Helpers;

class Validator {
    protected $errors = [];
    protected $data = [];
    
    public function __construct($data = []) {
        $this->data = $data;
    }
    
    public function required($field, $message = null) {
        if(empty($this->data[$field])) {
            $this->errors[$field] = $message ?? "{$field} is required";
        }
        
        return $this;
    }
    
    public function email($field, $message = null) {
        if(!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?? "{$field} must be a valid email";
        }
        
        return $this;
    }
    
    public function minLength($field, $length, $message = null) {
        if(!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?? "{$field} must be at least {$length} characters";
        }
        
        return $this;
    }
    
    public function maxLength($field, $length, $message = null) {
        if(!empty($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = $message ?? "{$field} must be no more than {$length} characters";
        }
        
        return $this;
    }
    
    public function matches($field, $matchField, $message = null) {
        if(!empty($this->data[$field]) && $this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field] = $message ?? "{$field} does not match {$matchField}";
        }
        
        return $this;
    }
    
    public function isValid() {
        return empty($this->errors);
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    public function getError($field) {
        return $this->errors[$field] ?? null;
    }
    /**
 * Validates that the specified fields contain numeric values
 * 
 * @param string|array $fields Field(s) to validate
 * @param string|null $message Custom error message
 * @return $this Returns validator instance for method chaining
 */
public function numeric($fields, $message = null) {
    // Convert single field to array
    if (!is_array($fields)) {
        $fields = [$fields];
    }
    
    foreach ($fields as $field) {
        // Skip if field is empty (empty values should be caught by required())
        if (empty($this->data[$field])) {
            continue;
        }
        
        if (!is_numeric($this->data[$field])) {
            $this->errors[$field] = $message ?? "Trường {$field} phải là số";
        }
    }
    
    return $this;
}
}