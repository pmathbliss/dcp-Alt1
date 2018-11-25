<?php

class testclass 
{

    private $args = [];
    private $sequences = [];
    private $numberOfArguments = 0;

    public function __construct($args)
    {
        $this->addFloatArgs($args);
        $this->numberOfArguments = count($this->args);
        $this->createSequence();
    }

    public function addFloatArgs($args)
    {
        foreach($args as $key => $value)
        {
            if($key == 0)
            {
                continue;
            }
            $this->args[$key] = (float)$value;
        }
    }

    public function createSequence()
    {
        //0, 8, 4, 12, 2, 10, 6, 14, 1, 9, 5, 13, 3, 11, 7, 15
        for($i = 1; $i < $this->numberOfArguments + 1; $i++)
        {    
            $currentNumber = $this->args[$i];

            if(!isset($this->sequences[$i]))//add starting node
            {
                $this->sequences[$i] = [];
            }

            for($j = $i+1; $j < $this->numberOfArguments+ 1; $j++)
            {
                $nextNumber = $this->args[$j];
                if($nextNumber <= $currentNumber)
                {
                    continue;
                }
                //echo "Add [{$i}][{$j}] {$currentNumber} -> {$nextNumber}" . PHP_EOL;
                $this->sequences[$i][$j] = $j;
            }
        }

    }

    private $longestSubSequence = [];
    private $lengthSubSequence  = 0;

    public function FindLongestSubSequence()
    {
        foreach($this->sequences as $key => $value)//$key is 1 to length of args
        {
            $currentSequence = [];
            
            if(empty($this->sequences[$key]))
            {
                continue;
            }

            $this->EachSequence($this->sequences[$key], $key,  $currentSequence);
            
            if($key > ($this->numberOfArguments - $this->lengthOfLongestSubSequence))
            {
                break;
            }
        }
        return $this->longestSubSequence;
    }

    public function EachSequence($sequence, $parentKey, $currentSequence)
    {
        $currentSequence[] = $this->args[$parentKey];

        if(empty($sequence))
        {            
            if(count($currentSequence) > count($this->longestSubSequence))
            {
                $this->longestSubSequence = $currentSequence;
                $this->lengthOfLongestSubSequence = count($currentSequence);
            }
            return;
        }

        foreach($sequence as $key => $values)
        {
            if($key == $parentKey)
            {
                continue;
            }
            $this->EachSequence($this->sequences[$key], $key, $currentSequence);
            
            //$this->walkTree($key);
            //$seq = [];

        }
    }
}

//$args = $argv;

$numberOfArguments = count($argv);

if($numberOfArguments < 2)
{
    die("Not enough arguments");
}

$r = new testclass($argv);
$longestSubSequence = $r->FindLongestSubSequence();

echo "Longest Subsequence " . implode(", ", $longestSubSequence);
