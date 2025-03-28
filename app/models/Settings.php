<?php
namespace App\Models;

/**
 * Settings Model
 */
class Settings extends BaseModel {
    protected $table = 'settings';
    protected $fillable = ['key', 'value', 'type', 'group'];
    
    /**
     * Get a setting value by key
     *
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed Setting value or default
     */
    public function getValue($key, $default = null) {
        $sql = "SELECT value, type FROM {$this->table} WHERE `key` = :key LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (!$result) {
            return $default;
        }
        
        // Type casting based on setting type
        $value = $result['value'];
        switch ($result['type']) {
            case 'boolean':
                return (bool)$value;
            case 'number':
                return is_numeric($value) ? (float)$value : $value;
            case 'json':
                return json_decode($value, true) ?: $value;
            default:
                return $value;
        }
    }
    
    /**
     * Set a setting value
     *
     * @param string $key Setting key
     * @param mixed $value Setting value
     * @param string $type Setting type (text, number, boolean, json, etc)
     * @param string $group Setting group
     * @return bool Success status
     */
    public function setValue($key, $value, $type = 'text', $group = 'general') {
        // Format value based on type
        if ($type === 'json' && is_array($value)) {
            $value = json_encode($value);
        }
        
        // Check if setting exists
        $sql = "SELECT id FROM {$this->table} WHERE `key` = :key LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':key', $key);
        $stmt->execute();
        
        if ($stmt->fetch()) {
            // Update existing setting
            $sql = "UPDATE {$this->table} SET `value` = :value, `type` = :type, `group` = :group, 
                    updated_at = CURRENT_TIMESTAMP WHERE `key` = :key";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':key', $key);
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':group', $group);
            
            return $stmt->execute();
        } else {
            // Create new setting
            return $this->create([
                'key' => $key,
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]) ? true : false;
        }
    }
    
    /**
     * Get all settings in a specific group
     *
     * @param string $group Group name
     * @return array Settings array
     */
    public function getByGroup($group) {
        $sql = "SELECT * FROM {$this->table} WHERE `group` = :group ORDER BY `key`";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':group', $group);
        $stmt->execute();
        
        $settings = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Format settings as key => value pairs
        $result = [];
        foreach ($settings as $setting) {
            $value = $setting['value'];
            // Type casting based on setting type
            switch ($setting['type']) {
                case 'boolean':
                    $value = (bool)$value;
                    break;
                case 'number':
                    $value = is_numeric($value) ? (float)$value : $value;
                    break;
                case 'json':
                    $value = json_decode($value, true) ?: $value;
                    break;
            }
            $result[$setting['key']] = $value;
        }
        
        return $result;
    }
    
    /**
     * Get all settings
     *
     * @return array Settings grouped by group
     */
    public function getAllSettings() {
        $sql = "SELECT * FROM {$this->table} ORDER BY `group`, `key`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $settings = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        // Group settings by group
        $result = [];
        foreach ($settings as $setting) {
            $value = $setting['value'];
            // Type casting based on setting type
            switch ($setting['type']) {
                case 'boolean':
                    $value = (bool)$value;
                    break;
                case 'number':
                    $value = is_numeric($value) ? (float)$value : $value;
                    break;
                case 'json':
                    $value = json_decode($value, true) ?: $value;
                    break;
            }
            
            if (!isset($result[$setting['group']])) {
                $result[$setting['group']] = [];
            }
            
            $result[$setting['group']][$setting['key']] = $value;
        }
        
        return $result;
    }
}