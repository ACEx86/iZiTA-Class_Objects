<?php
/**
 * Open Source GPLv3
 */
declare(strict_types=1);
namespace iZiTA
{
    //<editor-fold desc="Initialization Process">
    //<editor-fold desc=":: Check Startup ::">
    $included_files = False;
    ((__FILE__ ?? $included_files = True ?: $included_files = True) === (get_included_files()[0] ?? $included_files = True ?: $included_files = True)) ? True : ($included_files === False ? False : True) and exit('Closing on \iZiTA\Class_Objects.');
    //</editor-fold>
    date_default_timezone_set('UTC');
    defined('>\iZiTA\Class_Objects') or exit('Closing: >\iZiTA\Class_Objects is not defined.');
    //</editor-fold>
    /**
     * iZiTA::Class_Objects<br>
     * Script version: <b>202605.7.11.118</b><br>
     * PHP Version: <b>8.5</b><br>
     * <b>Info:</b><br>
     * iZiTA::Class_Objects is a library that loads the Classes of the libraries to be used as objects.<br>
     * Class_Objects create the objects of the Classes to be used for the selected caller Class\Action (instance).
     * <b>Details:</b><br>
     * <b>Construction</b>: Call Class_Objects::Construct() to initialize.<br>
     * <b>Usage</b>: Class_Objects::Call_Object_Handler('Object Name or Class Name', 'Function or Variable Name', Function's Argument('s) or Empty\Type Value to read-set Variable) to call an objects shared function or variable.<br>
     *
     * This class is responsible for managing object definitions and states within a system. It provides functionality
     * for defining, declaring, and constructing classes dynamically while ensuring proper initialization and validation.
     * @package iZiTA::Class_Objects
     * @author : TheTimeAuthority
     */
    Final Class Class_Objects
    {
        //<editor-fold desc="Initialize Class">
        /**
         * The constructor for <b>iZiTA::Class_Objects</b>.<br>
         * <b>Class_Objects Class</b> can be constructed <b>only once</b> per instance/request.
         * @param array $Classes The Classes to load or disable for this instance.<br>
         * Load later will not work for disabled Classes.
         * @param Bool $Load_Classes_Later If <b>True</b> you will be able to load other Classes not selected as disabled at Construction later.
         * @return Bool Returns <b>True</b> if Class is successfully Constructed and <b>False</b> on failure or if Class is in process or already Constructed.
         */
        Final Static Function Construct(array $Classes = [], Bool $Load_Classes_Later = False): Bool
        {
            if(isset(self::$is_Construction_Executing) === False
                and self::$is_Construction_Executing = True
                and isset(self::$is_Construction_Executing) === True
                and isset(self::$is_Class_Object) === False)
            {
                new Class_Objects(Classes:$Classes, Load_Classes_Later:$Load_Classes_Later);
                if(isset(self::$is_Class_Object) === True and self::$is_Class_Object instanceof \iZiTA\Class_Objects)
                {
                    self::$is_Construction_Executing = Null;
                    return True;
                }
            }
            self::$is_Construction_Executing = Null;
            return False;
        }
        /**
         * The constructor for iZiTA::Class_Objects
         */
        Final Private Function __construct(array $Classes, Bool $Load_Classes_Later = False, Int $Maximum_Objects = 15)
        {
            if(empty($Classes) === True)
            {
                if(isset(self::$is_Class_Object) === False
                    and isset($this->Class_Objects) === False
                    and isset($this->defined_Objects_at_Startup) === False
                    and isset($this->Load_Classes_Later) === False
                    and $Load_Classes_Later === True)
                {
                    $this->Load_Classes_Later = True;
                    if(isset($this->Load_Classes_Later) === True)
                    {
                        $this->Class_Objects = $this;
                        self::$is_Class_Object = $this->Class_Objects;
                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Construction: Empty classes, configured to load later.';
                    }
                    else
                    {
                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Construction: Failed to configure for late loading.';
                    }
                }
                else
                {
                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Construction failed, empty classes.';
                }
            }
            elseif(empty($Classes) === False
                and isset(self::$is_Class_Object) === False
                and isset($this->Class_Objects) === False
                and isset($this->defined_Objects_at_Startup) === False
                and isset($this->Load_Classes_Later) === False)
            {
                $defined_at_startup = [];
                $_loaded_Classes = [];
                $__Object = Null;
                $ignore_construction = True;
                if(isset($this->Maximum_Objects) === False and is_int($Maximum_Objects) === True and $Maximum_Objects < 999)
                {
                    $this->Maximum_Objects = $Maximum_Objects;
                }
                else# Set the default allowed to load Objects to 15
                {
                    $this->Maximum_Objects = 15;
                }
                $count_x = -1;
                foreach($Classes as $Object=>$State)
                {
                    $count_x += 1;
                    if($count_x > $Maximum_Objects)# Brake if more than x Objects is tried.
                    {
                        break;
                    }
                    if(is_string(value:$Object) === True
                        and mb_detect_encoding(string:$Object, encodings:'UTF-8', strict:True) === 'UTF-8'
                        and isset($State[0]) === True
                        and is_string($State[0]) === True
                        and mb_detect_encoding(string:$State[0], encodings:'UTF-8', strict:True) === 'UTF-8')
                    {
                        $Object = preg_replace(pattern:"/(^[^\p{L}_]+|[^\p{L}0-9_])/u", replacement:'', subject:$Object) ?? '';
                        $State[0] = preg_replace(pattern:"/(^[^\p{L}_]+|[^\p{L}0-9_])/u", replacement:'', subject:$State[0]) ?? '';
                        $the_Object = '';
                        if(isset($State[0]) === True and strlen(string:$State[0]) > 0)
                        {
                            $the_Object = ('\\'.((String)$State[0]).'\\'.((String)$Object));
                        }
                        elseif(isset($Object) === True and strlen(string:$Object) > 0)
                        {
                            $State[0] = '';
                            $the_Object = (String)$Object;
                        }
                        if(isset($Object) === True
                            and isset($State[0]) === True
                            and isset($State[1]) === True
                            and $State[1] === True)
                        {# Load enabled Class.
                            echo PHP_EOL.' [ I ] ( Class_Objects )                    Loading [ '.((String)$the_Object).' ].';
                            $required_file = ((String)$Object).'.php';
                            $loaded_file = False;
                            if(is_file(filename:$required_file) === True)
                            {# Declare define if needed and load file
                                $this->do_Define(define_Object:[$the_Object=>[$State[0],True]]);
                                $loaded_file = (Bool)((Require $required_file) ?? False);
                            }
                            else
                            {
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading [ '.((String)$the_Object).' ], php file not found.';
                            }
                            if($loaded_file === True)
                            {# File loaded
                                $Class_Object = Null;
                                if(class_exists(class:$the_Object, autoload:False) === True
                                    and enum_exists(enum:$the_Object, autoload:False) === False)
                                {# Class exist
                                    $Static_Function_Name = Null;
                                    $Function_Arguments = Null;
                                    $Failed_Loading = True;
                                    if(isset($State[2]) === True and is_string(value:$State[2]) === True)# Sanitize Function Name
                                    {
                                        $State[2] = preg_replace(pattern:"/(^[^\p{L}_]+|[^\p{L}0-9_])/u", replacement:'', subject:$State[2]) ?? '';
                                        $Static_Function_Name = $State[2];
                                    }
                                    if(isset($State[3]) === True and is_array(value:$State[3]) === True)# Sanitize Function Arguments
                                    {
                                        $Sanitized_Arguments = [];
                                        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($State[3]));
                                        $args_limit = -1;
                                        foreach($iterator as $key_value=>$argument)
                                        {
                                            $args_limit += 1;
                                            switch($args_limit)
                                            {
                                                case ($args_limit > 99):
                                                    break;
                                            }
                                            switch($argument)
                                            {
                                                case($argument === Null):
                                                case(is_string($argument) === True):
                                                case(is_float($argument) === True):
                                                case(is_int($argument) === True):
                                                case(is_bool($argument) === True):
                                                {
                                                    $Sanitized_Arguments[] = $argument;
                                                    break;
                                                }
                                                default:
                                                {
                                                    $Sanitized_Arguments = [];
                                                    break;
                                                }
                                            }
                                        }
                                        if(isset($Sanitized_Arguments) === True)
                                        {
                                            $Function_Arguments = $Sanitized_Arguments;
                                        }
                                    }
                                    # Change Construction Execution Scope If Needed
                                    if($State[2] === Null or $State[2] === '')
                                    {
                                        $Static_Function_Name = '__construct';
                                    }
                                    if(is_string(value:$Static_Function_Name) === True and method_exists(object_or_class:$the_Object, method:$Static_Function_Name) === True)
                                    {# Function Call
                                        # Maybe remove reflection from here and add it in a func
                                        $is_Method = Null;
                                        $is_Method = new \ReflectionMethod($the_Object, $Static_Function_Name);
                                        $is_Parameters = $is_Method->getParameters();
                                        # Match Arguments With Call Arguments
                                        $Pass = False;
                                        if(is_array($Function_Arguments) === True)
                                        {
                                            $requested_arguments_count = count(value:$State[3]);
                                            if(isset($is_Parameters) === True
                                                and count(value:$is_Parameters) > 0
                                                and count(value:$is_Parameters) >= $requested_arguments_count)
                                            {
                                                $args_x = -1;
                                                foreach($is_Parameters as $Parameter)
                                                {
                                                    $args_x += 1;
                                                    if($args_x > count(value:$State[3]))
                                                    {
                                                        break;
                                                    }
                                                    if($this->check_arguments_case(Reflection:$Parameter, Argument:$State[3][$args_x]) === True)
                                                    {
                                                        $Pass = True;
                                                    }
                                                    else
                                                    {
                                                        $Pass = False;
                                                        break;
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                echo PHP_EOL . ' [ !I ] ( Class_Objects )                   Error: Incorrect Arguments [ ' . ((String)$the_Object) . ' ].';
                                            }
                                        }
                                        # Try Creating Object
                                        if(isset($is_Method) === True and $is_Method->isPrivate() === False and $is_Method->isStatic() === True)
                                        {
                                            $Class_Object = Null;
                                            $is_Parameters = $is_Method->getParameters();#Methods Parameters
                                            if(is_array(value:$Function_Arguments) === True)
                                            {
                                                if($Pass === True)
                                                {
                                                    $Class_Object = ($the_Object)::{$State[2]}(...$Function_Arguments);
                                                    $Failed_Loading = False;
                                                }
                                                else
                                                {
                                                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Arguments [ '.$the_Object.'::'.$State[2].' ].';
                                                }
                                            }
                                            elseif(isset($is_Parameters) === True and is_array(value:$is_Parameters) === True and count(value:$is_Parameters) === 0)
                                            {
                                                $Class_Object = ($the_Object)::{$State[2]}();
                                                $Failed_Loading = False;
                                            }
                                            else
                                            {
                                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Function Call > Missing Arguments. [ '.$State[0].$Object.' ].';
                                            }
                                        }
                                        elseif(isset($is_Method) === True and $is_Method->isPrivate() === False and $is_Method->isStatic() === False)
                                        {
                                            if(isset($is_Parameters) === True and is_array(value:$is_Parameters) === True and count(value:$is_Parameters) === 0)
                                            {
                                                $Class_Object = new ($the_Object);
                                            }
                                            elseif($Pass === True)
                                            {
                                                $Class_Object = new ($the_Object)(...$Function_Arguments);
                                            }
                                            else
                                            {
                                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect constructor call > Missing Arguments. [ '.$the_Object.' ].';
                                            }
                                        }
                                        elseif($Static_Function_Name === '__construct')
                                        {
                                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Constructor is not accessible > [ '.$the_Object.' ]';
                                        }
                                        else
                                        {
                                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Function is not accessible > [ '.$State[0].$Object.' '.$Static_Function_Name.' ]';
                                        }
                                        $is_Method = Null;
                                        $is_Parameters = Null;
                                        unset($is_Method);
                                        unset($is_Parameters);
                                    }
                                    elseif($Function_Arguments === Null and method_exists(object_or_class:$the_Object, method:'__construct') === False)# new Class no input.
                                    {
                                        $Class_Object = new ($the_Object);
                                    }
                                    else
                                    {
                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed Loading Class [ '.((String)$the_Object).' ].';
                                    }
                                    if(isset($Class_Object) === True
                                        and is_object($Class_Object) === True
                                        and $Class_Object instanceof $the_Object)
                                    {
                                        $Failed_Loading = False;
                                    }
                                    if($Failed_Loading === False and isset($Class_Object) === True
                                        and is_object(value:$Class_Object) === True
                                        and $Class_Object instanceof ($the_Object) === True
                                        and $__Object[(String)($the_Object)][0] = $Class_Object
                                        and $__Object[(String)($the_Object)][1] = True
                                        and $__Object[(String)($the_Object)][0] instanceof ($the_Object) === True)
                                    {
                                        $defined_at_startup[$the_Object] = [$State[0],True];
                                        $_loaded_Classes[$the_Object] = [0=>$State[0],1=>$State[1]];
                                        $Class_Object = Null;
                                        $ignore_construction = False;
                                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Loaded Class: [ '.$the_Object.' ].';
                                    }
                                    elseif($Failed_Loading === False
                                        and $__Object[(String)($the_Object)][0] = ''
                                        and $__Object[(String)($the_Object)][1] = True)
                                    {
                                        $defined_at_startup[$the_Object] = [$State[0],True];
                                        $_loaded_Classes[$the_Object] = [0=>$State[0],1=>$State[1]];
                                        $Class_Object = Null;
                                        $ignore_construction = False;
                                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Loaded Static Class: [ '.$the_Object.' ].';
                                    }
                                    else
                                    {
                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed Loading Class [ '.$the_Object.' ].';
                                    }
                                }
                                else
                                {
                                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Class not found [ '.((String)$the_Object).' ].';
                                    exit;
                                }
                                unset($Class_Object);
                            }
                            else
                            {
                                $defined_at_startup[$the_Object] = [$State[0],False];
                                unset($required_file);
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed loading requires for [ '.$Object.' ].';
                            }
                        }
                        elseif(isset($Object) === True
                            and isset($State[0]) === True
                            and isset($State[1]) === True
                            and $State[1] === False)# Add disabled Object to list.
                        {
                            #Only add files that exist to disabled list?
                            $required_file = ((String)$Object).'.php';
                            if(is_file(filename:$required_file) === True)
                            {
                                $defined_at_startup[$the_Object] = [$State[0],False];
                                $__Object[(String)($the_Object)][0] = '';
                                $__Object[(String)($the_Object)][1] = False;
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Added disabled object to list [ '.((String)$the_Object).' ].';
                            }
                            else
                            {
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Not found. Failed adding disabled object to list [ '.((String)$the_Object).' ].';
                            }
                        }
                        else# Wrong enabled status type.
                        {
                            $defined_at_startup[$the_Object] = [$State[0],False];
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Malformed options. Object [ '.((String)$the_Object).' ] have not loaded.';
                        }
                    }
                    else# Display error statuses ( Class Name and Namespace )
                    {
                        if(is_string(value:$Object) === False)
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Malformed Object. Loading failed for Object '.$count_x.'.';
                        }
                        elseif(mb_detect_encoding(string:$Object, encodings:'UTF-8', strict:True) !== 'UTF-8')
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect encoding for Objects Class name. Loading failed for Object '.$count_x.'.';
                        }
                        elseif(isset($State[0]) === False)
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Missing Namespace option. Loading failed for Object '.$count_x.'.';
                        }
                        elseif(is_string(value:$State[0]) === False)
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect NameSpace type. Loading failed for Object '.$count_x.'.';
                        }
                        elseif(mb_detect_encoding(string:$State[0], encodings:'UTF-8', strict:True) !== 'UTF-8')
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect encoding for Objects NameSpace. Loading failed for Object '.$count_x.'.';
                        }
                        else
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Unknown error. Loading failed for Object '.$count_x.'.';
                        }
                    }
                }
                if($ignore_construction === False
                    and isset($this->Class_Objects) === False)
                {
                    $this->defined_Objects_at_Startup = $defined_at_startup;
                    if(isset($this->defined_Objects_at_Startup) === True)
                    {
                        $this->Class_Objects = $this;
                        $this->Load_Classes_Later = $Load_Classes_Later;
                        $this->loaded_Objects = $_loaded_Classes;
                        self::$is_Class_Object = $this->Class_Objects;
                        $this->__Object = $__Object;
                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Construction of Class_Objects completed.';
                    }
                    else
                    {
                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Construction of Class_Objects failed. Failed writing defines.';
                    }
                }
                elseif($ignore_construction === True
                    and isset($this->Load_Classes_Later) === False
                    and $Load_Classes_Later === True)
                {
                    $this->Load_Classes_Later = True;
                    if(isset($this->Load_Classes_Later) === True)
                    {
                        $this->Class_Objects = $this;
                        self::$is_Class_Object = $this->Class_Objects;
                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Construction: Empty classes, configured to load later.';
                    }
                    else
                    {
                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Construction: Failed to configure late loading.';
                    }
                }
                $_loaded_Classes = Null;
                unset($_loaded_Classes);
                $__Object = Null;
                unset($__Object);
            }
            elseif(isset(self::$is_Class_Object) === True)
            {
                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Class_Objects already loaded for instance.';
            }
            else
            {
                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Class_Objects construction failed.';
            }
        }
        //</editor-fold>
        //<editor-fold desc="Variables">
        //<editor-fold desc="Private Variables">
        //<editor-fold desc="Private fail-safe indicators">
        /**
         * @var \iZiTA\Class_Objects
         * Returns the Object of <b>\iZiTA\Class_Objects</b>.
         */
        Private ReadOnly \iZiTA\Class_Objects $Class_Objects;
        /**
         * @var array $defined_Objects_at_Startup
         * This ReadOnly array holds the startup defined objects.
         */
        Private ReadOnly array $defined_Objects_at_Startup;
        /**
         * @var array $loaded_Objects
         * This array is a dummy shadow array that holds the statuses of the <b>Objects</b> that <b>have loaded</b> successfully at startup.
         */
        Private ReadOnly array $loaded_Objects;
        /**
         * @var Bool $Load_Classes_Later
         * This bool control whether later loading of Classes is allwoed.
         */
        Private ReadOnly Bool $Load_Classes_Later;
        Private ReadOnly Int $Maximum_Objects;
        //</editor-fold>
        //<editor-fold desc="Private Static Variables">
        /**
         * @var ?\iZiTA\Class_Objects
         * Returns the Object of <b>\iZiTA\Class_Objects</b>.
         */
        Private Static ?\iZiTA\Class_Objects $is_Class_Object = Null;
        Private Static ?Bool $is_Construction_Executing = Null;
        //</editor-fold>
        //<editor-fold desc="Private Hooked Class Objects [v8]">
        /**
         * @var ?Object
         * This is the <b>Object</b> of the <b>Class</b> that was requested.<br>
         * This is not for writing, it passes the object from the array of objects.
         */
        Private ?Object $Object_Reference = Null
            {
                get
                {
                    if(isset($this->Object_Reference) === True)
                    {
                        $return = $this->Object_Reference;
                        $this->Object_Reference = Null;
                        return $return;
                    }
                    return Null;
                }
                set(?Object $Object_Reference)
                {
                    if(isset($this->Object_Reference) === False or $Object_Reference === Null)
                    {
                        $this->Object_Reference = $Object_Reference;
                    }
                }
            }
        /**
         * @var String This is the Class Name of the object that was requested.
         * <b>Not for writing. This is for internal use only.</b>
         */
        Private String $__Class_Name = ''
            {
                get
                {
                    if(isset($this->__Class_Name) === True)
                    {
                        $return = $this->__Class_Name;
                        $this->__Class_Name = '';
                        return $return;
                    }
                    return '';
                }
                set(String $Class_Name)
                {
                    if(isset($this->__Class_Name) === True and $this->__Class_Name === '')
                    {
                        if(mb_detect_encoding(string:$Class_Name, encodings:'UTF-8', strict:True) === 'UTF-8')
                        {
                            $Class_Name = preg_replace(pattern:"/(^[^\p{L}_\\\]+|[^\p{L}0-9_\\\])/u", replacement:'', subject:$Class_Name);
                            if(isset($Class_Name) === True)
                            {
                                $this->__Class_Name = $Class_Name;
                            }
                        }
                    }
                    $Class_Name = '';
                }
            }
        /**
         * @var ?array
         * This is the array of objects <b>iZiTA::__Object</b> of the loaded classes.<br>
         * It will be used to access the accessible properties and methods inside the classes.<br>
         * It returns the selected object.
         */
        Private ?array $__Object = Null
            {
                get
                {
                    if(isset($this->__Object) === True)
                    {
                        $__Class_Name = $this->__Class_Name ?? Null;
                        if(isset($__Class_Name) === True
                            and empty($__Class_Name) === False
                            and mb_detect_encoding(string:$__Class_Name, encodings:'UTF-8', strict:true) === 'UTF-8'
                            and strlen(string:$__Class_Name) > 0)
                        {
                            $__Class_Name = preg_replace(pattern:"/(^[^\p{L}_\\\]+|[^\p{L}0-9_\\\])/u", replacement:'', subject:$__Class_Name);
                            if(isset($__Class_Name) === True)
                            {
                                if(is_object(value:$this->__Object[0][$__Class_Name][0]) === True)
                                {
                                    $this->Object_Reference = $this->__Object[0][$__Class_Name][0];
                                    return ['1'];
                                }
                                return Null;
                            }
                            else
                            {
                                return Null;
                            }
                        }
                        return [''];
                    }
                    return Null;
                }
                set(?array $__Object)
                {
                    if(isset($this->__Object) === False)
                    {
                        $this->__Object[] = $__Object;
                        $__Object = Null;
                        unset($__Object);
                    }
                }
            }
        //</editor-fold>
        //</editor-fold>
        //</editor-fold>
        //<editor-fold desc="Functions [v2]">
        //<editor-fold desc="Private Functions">
        Private Function do_Define(array $define_Object = []): Bool
        {
            echo PHP_EOL.' [ + ] ( Class_Objects )                    do_Defined: Called.';
            $defined_successfully = False;
            if(isset($define_Object) === True and empty($define_Object) === False)
            {
                foreach($define_Object as $Object=>$State)
                {
                    if(is_string(value:$Object) === True
                        and mb_detect_encoding(string:$Object, encodings:'UTF-8', strict:True) === 'UTF-8')
                    {# Class Name
                        $Object = preg_replace(pattern:"/[^\p{L}\p{Nd}_]/u", replacement:'', subject:$Object);
                        if(isset($State[0]) === True)
                        {# Namespace
                            if(is_string(value:$State[0]) === True
                                and mb_detect_encoding(string:$State[0], encodings:'UTF-8', strict:True) === 'UTF-8')
                            {
                                $State[0] = preg_replace(pattern:"/[^\p{L}0-9_]/u", replacement:'', subject:$State[0]);
                            }
                            else
                            {
                                echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Object containing malformed Namespace data was skipped.';
                                continue;
                            }
                        }
                        $define = '';
                        if(isset($Object) === True)
                        {
                            if(isset($State[0]) === True)
                            {
                                $Object = str_replace(search:$State[0], replace:'', subject:$Object);
                                $define = ('>\\'.((String)$State[0]).'\\'.((String)$Object));
                            }
                            else
                            {
                                $define = ('>'.((String)$Object));
                            }
                        }
                        if(isset($Object) === True
                            and isset($State[1]) === True
                            and is_bool(value:$State[1]) === True
                            and $State[1] === True)
                        {
                            $bypass_disabled_fix = True;
                            if(isset($this->defined_Objects_at_Startup[$Object]) === True)
                            {# Check to see if define exists to fix disabled bypass.
                                if(isset($this->defined_Objects_at_Startup[$Object][0]) === True and $this->defined_Objects_at_Startup[$Object][0] === $define_Object[$Object][$State[0]])
                                {
                                    if(isset($this->defined_Objects_at_Startup[$Object][$State[0]][1]) === True)
                                    {
                                        if(!($this->defined_Objects_at_Startup[$Object][$State[0]][1] === $State[1]))
                                        {
                                            $bypass_disabled_fix = False;
                                        }
                                    }
                                    else
                                    {
                                        $bypass_disabled_fix = False;
                                    }
                                }
                                else
                                {
                                    if(isset($this->defined_Objects_at_Startup[$Object][1]) === True)
                                    {
                                        if(!($this->defined_Objects_at_Startup[$Object][1] === $State[1]))
                                        {
                                            $bypass_disabled_fix = False;
                                        }
                                    }
                                    else
                                    {
                                        $bypass_disabled_fix = False;
                                    }
                                }
                            }
                            if($bypass_disabled_fix === True)
                            {
                                if(defined(constant_name:$define) === True)
                                {
                                    exit(' [ ! ] ( Class_Objects )                    do_Defined: Tried to re_define [ '.$define.' ].');
                                }
                                elseif(defined(constant_name:$define) === False)
                                {
                                    $is_defined = define(constant_name:$define, value:True);
                                    if($is_defined === True and defined(constant_name:$define) === True)
                                    {
                                        echo PHP_EOL.' [ + ] ( Class_Objects )                    do_Defined: Successfully defined [ '.$define.' ].';
                                        $defined_successfully = True;
                                    }
                                    else
                                    {
                                        echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Failed defining [ '.$define.' ].';
                                    }
                                }
                            }
                        }
                        elseif(isset($Object) === True
                            and isset($State[1]) === True
                            and is_bool(value:$State[1]) === True
                            and $State[1] === False
                            and defined(constant_name:$define) === True)
                        {
                            exit(' [ ! ] ( Class_Objects )                    do_Defined: Warning->Disabled object is defined '.$define);
                        }
                        else
                        {
                            echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Object with malformed enable status data skipped.';
                        }
                    }
                    else
                    {
                        echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Malformed object skipped.';
                    }
                }
            }
            else
            {
                echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: No objects to define.';
            }
            if($defined_successfully === True)
            {
                return True;
            }
            else
            {
                return False;
            }
        }
        Private Function check_arguments_case(\ReflectionParameter|\ReflectionProperty $Reflection, array|String|Int|Float|Bool|Null $Argument): Bool
        {
            $is_Parameter = '';
            $is_Parameter = strtolower(string:(String)$Reflection->getType()) ?: '';
            $has_type_Parameter = ($Reflection->hasType() ?? False);
            $Parameter_Type = strtolower(string:(String)gettype(value:$Argument));
            if(isset($is_Parameter) === True)
            {
                switch(True)
                {
                    case(str_contains(haystack:$is_Parameter, needle:$Parameter_Type) === True):
                    case(str_contains(haystack:$is_Parameter, needle:'?') === True and gettype(value:$Argument) === 'NULL' and $Argument === Null):
                    case($has_type_Parameter === False and (is_array(value:$Argument) === True or is_string(value:$Argument) or is_float(value:$Argument) === True or is_int(value:$Argument) === True or is_bool(value:$Argument) === True or $Argument === Null)):
                    case($Reflection->isVariadic() === True and is_array(value:$Argument) === True):
                    {
                        return True;
                    }
                    default:
                    {
                        return False;
                    }
                }
            }
            return False;
        }
        Private Function Sanitize_Array_Arguments(array $Argument): array
        {
            $Sanitized_Arguments = [];
            if(empty($Argument) === False)
            {
                $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($Argument));
                $max_recursive_itteration = -1;
                foreach($iterator as $key_value=>$arguments)
                {
                    $max_recursive_itteration += 1;
                    if($max_recursive_itteration > 1000)
                    {
                        break;
                    }
                    switch($arguments)
                    {
                        case($arguments === Null):
                        case(is_string($arguments) === True):
                        case(is_float($arguments) === True):
                        case(is_int($arguments) === True):
                        case(is_bool($arguments) === True):
                        {
                            $Sanitized_Arguments[] = $arguments;
                        }
                    }
                }
            }
            return $Sanitized_Arguments;
        }
        Private Function is_array_multidimensional(array $array): Bool
        {
            return array_any($array, fn($key) => is_array($key) === True);
        }
        /**
         * Calls a specified method or accesses/modifies a property of an object by dynamically resolving the object reference.
         * @param string $Object_Name The name of the target object ( Class ) to operate on.
         * @param string $Object_Function The name of the method to invoke or the property to access/modify.
         * @param mixed ...$Arguments Optional arguments to pass to the method or to assign to the property.
         * @return array|String|Float|Int|Bool
         * Returns the result of the method invocation or property value modification.
         * Returns <b>`True`</b> if a void function is executed successfully.
         * Returns <b>`False`</b> if there is an error in the execution.
         */
        Private Function Call_Object(string $Object_Name, String $Object_Function, ...$Arguments): array|String|Float|Int|Bool
        {
            if(is_array(value:$Arguments) === True
                and isset($this->__Object) === True
                and $this->__Class_Name = $Object_Name
                and isset($this->__Object) === True)
            {
                $Referred_Class_Grabber = $this->Object_Reference ?? Null;
                if(isset($Referred_Class_Grabber) === True and is_object(value:$Referred_Class_Grabber) === True)
                {
                    $this->Object_Reference = Null;
                    $this->__Class_Name = '';
                    $Object_Name = '';
                    if(method_exists(object_or_class:$Referred_Class_Grabber, method:$Object_Function) === True)
                    {# Perform operation on a function.
                        $is_Method = new \ReflectionMethod($Referred_Class_Grabber, $Object_Function);
                        $is_private = $is_Method->isPrivate() ?? False;
                        $Returned_Error = False;
                        $Return_is_Void = False;
                        $Return = Null;
                        if($is_private === False)
                        {
                            $Pass = False;
                            if(count(value:$Arguments) === 0)
                            {
                                $Pass = True;
                            }
                            else
                            {
                                $is_Parameters = $is_Method->getParameters();
                                if(isset($is_Parameters) === True and count(value:$is_Parameters) > 0 and count(value:$Arguments) > 0 and count(value:$is_Parameters) >= count(value:$Arguments))
                                {
                                    $args_x = -1;
                                    foreach($is_Parameters as $Parameter)
                                    {
                                        $args_x += 1;
                                        if(isset($Arguments[$args_x]) === False)
                                        {
                                            break;
                                        }
                                        if($this->check_arguments_case(Reflection:$Parameter, Argument:$Arguments[$args_x]) === True)
                                        {
                                            $Pass = True;
                                            break;
                                        }
                                        else
                                        {
                                            $Pass = False;
                                            break;
                                        }
                                    }
                                }
                                else
                                {
                                    $Pass = False;
                                }
                            }
                            if($Pass === True)
                            {
                                $is_static = $is_Method->isStatic() ?? False;
                                if(empty($Arguments) === False)
                                {
                                    if($is_static === True)
                                    {
                                        $Return = $Referred_Class_Grabber::$Object_Function(...$Arguments);
                                    }
                                    else
                                    {
                                        $Return = $Referred_Class_Grabber->$Object_Function(...$Arguments);
                                    }
                                }
                                elseif(empty($Arguments) === True)
                                {
                                    if($is_static === True)
                                    {
                                        $Return = $Referred_Class_Grabber::$Object_Function();
                                    }
                                    else
                                    {
                                        $Return = $Referred_Class_Grabber->$Object_Function();
                                    }
                                }
                                if($Return === Null)
                                {
                                    $Return_is_Void = True;
                                }
                                else
                                {
                                    if(is_array(value:$Return) === False
                                        and is_string(value:$Return) === False
                                        and is_float(value:$Return) === False
                                        and is_int(value:$Return) === False
                                        and is_bool(value:$Return) === False)
                                    {
                                        $Returned_Error = True;
                                    }
                                }
                            }
                            else
                            {
                                $Returned_Error = True;
                            }
                        }
                        else
                        {
                            $Returned_Error = True;
                        }
                        if($Return !== Null and $Returned_Error === False)
                        {
                            if(is_array(value:$Return) === True)
                            {
                                $Return = $this->Sanitize_Array_Arguments($Return);
                            }
                            return $Return;
                        }
                        elseif($is_private === True)
                        {
                            echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Cannot access Private Function [ '.$Object_Function.' ].';
                        }
                        elseif($Returned_Error === True)
                        {
                            echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Failed executing function [ '.$Object_Function.' ], wrong arguments.';
                        }
                        elseif($Return_is_Void === True)
                        {
                            echo PHP_EOL.' [ + ] ( Class_Objects )                    Call_Object: Void function executed.';
                            return True;
                        }
                        else
                        {
                            echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Failed executing function [ '.$Object_Function.' ].';
                        }
                    }
                    elseif(property_exists(object_or_class:$Referred_Class_Grabber, property:$Object_Function) === True and isset($Referred_Class_Grabber->$Object_Function) === True)
                    {# Perform operation on a variable.
                        $is_property = new \ReflectionProperty($Referred_Class_Grabber, $Object_Function);
                        $is_property_private = $is_property->isPrivate() ?? False;
                        if($is_property_private === False)
                        {
                            $is_property_static = $is_property->isStatic() ?? False;
                            $Return = Null;
                            if(empty($Arguments) === True)
                            {# Read Variable
                                if($is_property_static === True)
                                {
                                    $Return = $Referred_Class_Grabber::$Object_Function;
                                }
                                else
                                {
                                    $Return = $Referred_Class_Grabber->$Object_Function;
                                }
                            }
                            elseif(count(value:$Arguments) === 1)
                            {# Set Variable
                                if($this->check_arguments_case(Reflection:$is_property, Argument:$Arguments[0]) === True)
                                {
                                    if(is_array($Arguments[0]) === True)
                                    {
                                        $Argument[0] = $this->Sanitize_Array_Arguments($Arguments[0]);
                                    }
                                    $Return = True;
                                    if($is_property_static === True)
                                    {
                                        $Referred_Class_Grabber::$Object_Function = $Arguments[0];
                                    }
                                    else
                                    {
                                        $Referred_Class_Grabber->$Object_Function = $Arguments[0];
                                    }
                                }
                                else
                                {
                                    echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Unsupported variable call.';
                                }
                            }
                            else
                            {
                                echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Malformed arguments for Object [ '.((String)$Object_Name).' ].';
                            }
                            if(isset($Return) === True)
                            {
                                if(is_array(value:$Return) === True)
                                {# Check return array for blocked types.
                                    $Return = $this->Sanitize_Array_Arguments($Return);
                                    return $Return;
                                }
                                else
                                {
                                    return $Return;
                                }
                            }
                        }
                        else
                        {
                            echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Cannot access Private Property [ '.((String)$Object_Function).' ].';
                        }
                    }
                    else
                    {
                        echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Failed executing call to non-existent method or object [ '.((String)$Object_Name).' > '.((String)$Object_Function).' ].';
                    }
                }
                else
                {
                    echo PHP_EOL.' [ !! ] ( Class_Objects )                   Call_Object: Object [ '.((String)$Object_Name).' ] does not exist.';
                }
            }
            else
            {
                echo PHP_EOL.' [ ! ] ( Class_Objects )                    Call_Object: Object [ '.((String)$Object_Name).' ] does not exist.';
            }
            return False;
        }
        //</editor-fold>
        //<editor-fold desc="Final Functions">
        /**
         * Check if Class_Object is constructed.
         * @return bool Returns <b>`True`</b> if Class_Object is constructed <b>`False`</b> otherwise.
         */
        Final Static Function isset_Class_Object(): Bool
        {
            if(isset(self::$is_Class_Object) === True and self::$is_Class_Object instanceof \iZiTA\Class_Objects)
            {
                return True;
            }
            return False;
        }
        /**
         * Calls a specified method or accesses/modifies a property of an object by dynamically resolving the object reference.
         * @param string $Object_Name The name of the target object ( Class ) to operate on.
         * @param string $Object_Function The name of the method to invoke or the property to access/modify.
         * @param mixed ...$Arguments Optional arguments to pass to the method or to assign to the property.
         * @return array|String|Float|Int|Bool|Null
         * Returns the result of the method invocation or property value modification.
         * Returns <b>`True`</b> if a void function executed successfully.
         * Returns <b>`False`</b> on execution error.
         */
        Final Static Function Call_Object_Handler(String $Object_Name, String $Object_Function, ...$Arguments): array|String|Float|Int|Bool|Null
        {
            if(isset(self::$is_Class_Object) === True and self::$is_Class_Object instanceof \iZiTA\Class_Objects)
            {
                return self::$is_Class_Object->Call_Object($Object_Name, $Object_Function, ...$Arguments);
            }
            return Null;
        }
        //</editor-fold>
        //</editor-fold>
    }
}?>
