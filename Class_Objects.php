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
     * Script version: <b>202604.7.10.99</b><br>
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
         * The constructor for iZiTA::Class_Objects
         * @return Bool Returns <b>True</b> if Class is successfully Constructed and <b>False</b> on failure or if Class is already Constructed.
         */
        Final Static Function Construct(array $Classes = []): Bool
        {
            if(isset(self::$is_Class_Object) === False)
            {
                new Class_Objects($Classes);
                if(isset(self::$is_Class_Object) === True and self::$is_Class_Object instanceof \iZiTA\Class_Objects)
                {
                    return True;
                }
            }
            return False;
        }
        /**
         * The constructor for iZiTA::Class_Objects
         */
        Final Private Function __construct(ReadOnly array $Classes)
        {
            if(empty($Classes) === True)
            {
                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Construction failed, empty classes.';
            }
            elseif(empty($Classes) === False and isset(self::$is_Class_Object) === False and isset($this->Class_Objects) === False and isset($this->define_Objects) === False)
            {
                $this->define_Objects = $Classes;
                if(isset($this->define_Objects) === True)
                {
                    echo PHP_EOL.' [ +I ] ( Class_Objects )                   Defines declared successfully.';
                }
                else
                {
                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed to declare defines.';
                }
                $this->do_Defined();
                $__Object = Null;
                $_loaded_Classes = [];
                $ignore_construction = True;
                foreach($Classes as $Object=>$State)
                {
                    if(is_string($Object) === True and mb_detect_encoding($Object, 'UTF-8', True) === 'UTF-8' and isset($State[0]) === True and is_string($State[0]) === True and mb_detect_encoding($State[0], 'UTF-8', True) === 'UTF-8')
                    {
                        $Object = preg_replace("/[^\p{L}\p{Nd}_]/u", '', $Object) ?: $Object = '';
                        $State[0] = preg_replace("/[^\p{L}0-9]/u", '', $State[0]) ?: $State[0] = '';
                        if(isset($State[1]) === True and $State[1] === True)
                        {# Load enabled Class.
                            echo PHP_EOL.' [ I ] ( Class_Objects )                    Loading '.$State[0].((String)$Object).'.';
                            $required_file = ((String)$Object).'.php';
                            $loaded_file = False;
                            if(is_file($required_file) === True)
                            {
                                $loaded_file = (Bool)((Require $required_file) ?? False);
                            }
                            else
                            {
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading [ '.$Object.'.php ], file not found.';
                            }
                            if($loaded_file === True)
                            {
                                $Class_Object = Null;
                                if(class_exists((((String)$State[0]).((String)$Object)), False) === True and enum_exists((((String)$State[0]).((String)$Object)), False) === False)
                                {
                                    $Static_Function_Name = Null;
                                    $Function_Arguments = Null;
                                    $Failed_Loading = True;
                                    if(isset($State[2]) === True and is_string($State[2]) === True)
                                    {
                                        $Static_Function_Name = $State[2];
                                    }
                                    if(isset($State[3]) === True and is_array($State[3]) === True)
                                    {
                                        $Function_Arguments = $State[3];
                                    }
                                    if(is_string($Static_Function_Name) === True and method_exists((((String)$State[0]).((String)$Object)), $Static_Function_Name) === True)
                                    {
                                        $is_Method = Null;
                                        $is_Method = new \ReflectionMethod((((String)$State[0]).((String)$Object)), $Static_Function_Name);
                                        if(isset($is_Method) === True and $is_Method->isPrivate() === False and $is_Method->isStatic() === True)
                                        {
                                            $Class_Object = Null;
                                            $is_Parameters = $is_Method->getParameters();#Methods Parameters
                                            if(is_array($Function_Arguments) === True)
                                            {
                                                if(isset($is_Parameters) === True and count($is_Parameters) > 0 and count($is_Parameters) === count($State[3]))
                                                {
                                                    $args_x = -1;
                                                    $Pass = False;
                                                    foreach($is_Parameters as $Parameter)
                                                    {
                                                        $args_x += 1;
                                                        if($this->check_arguments_case($Parameter, $State[3][$args_x]) === True)
                                                        {
                                                            $Pass = True;
                                                        }
                                                        else
                                                        {
                                                            $Pass = False;
                                                            break;
                                                        }
                                                    }
                                                    if($Pass === True)
                                                    {
                                                        $Failed_Loading = False;
                                                        $Class_Object = ((((String)$State[0]).((String)$Object)))::{$State[2]}(...$State[3]);
                                                    }
                                                    else
                                                    {
                                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Arguments [ '.$State[0].$Object.'::'.$State[2].' ].';
                                                    }
                                                }
                                                else
                                                {
                                                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Arguments [ '.$State[0].$Object.' ].';
                                                }
                                            }
                                            elseif(isset($is_Parameters) === True and is_array($is_Parameters) === True and count($is_Parameters) === 0)
                                            {
                                                $Failed_Loading = False;
                                                $Class_Object = ((((String)$State[0]).((String)$Object)))::{$State[2]}();
                                            }
                                            else
                                            {
                                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Function Call > Missing Arguments. [ '.$State[0].$Object.' ].';
                                            }
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
                                    elseif(is_string($Static_Function_Name) === False)
                                    {
                                        if($Function_Arguments === Null and method_exists((((String)$State[0]).((String)$Object)), '__construct') === False)
                                        {
                                            $Failed_Loading = False;
                                            $Class_Object = new ((((String)$State[0]).((String)$Object)));
                                        }
                                        elseif(method_exists((((String)$State[0]).((String)$Object)), '__construct') === True)
                                        {
                                            $is_Method = new \ReflectionMethod((((String)$State[0]).((String)$Object)), '__construct');
                                            if($is_Method->isPrivate() === False and $is_Method->isStatic() === False)
                                            {
                                                $Class_Object = Null;
                                                $is_Parameters = $is_Method->getParameters();
                                                if(is_array($Function_Arguments) === True)
                                                {
                                                    if(isset($is_Parameters) === True and count($is_Parameters) > 0 and count($is_Parameters) === count($State[3]))
                                                    {
                                                        $args_x = -1;
                                                        $Pass = False;
                                                        foreach($is_Parameters as $Parameter)
                                                        {
                                                            $args_x += 1;
                                                            if($this->check_arguments_case($Parameter, $State[3][$args_x]) === True)
                                                            {
                                                                $Pass = True;
                                                            }
                                                            else
                                                            {
                                                                $Pass = False;
                                                                break;
                                                            }
                                                        }
                                                        if($Pass === True)
                                                        {
                                                            $Failed_Loading = False;
                                                            $Class_Object = new ((((String)$State[0]).((String)$Object)))(...$State[3]);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect Arguments [ '.$State[0].$Object.' ].';
                                                    }
                                                }
                                                elseif(isset($is_Parameters) === True and is_array($is_Parameters) === True and count($is_Parameters) === 0)
                                                {
                                                    $Failed_Loading = False;
                                                    $Class_Object = new ((((String)$State[0]).((String)$Object)));
                                                }
                                                else
                                                {
                                                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Incorrect constructor call > Missing Arguments. [ '.$State[0].$Object.' ].';
                                                }
                                            }
                                            else
                                            {
                                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Constructor is not accessible > [ '.$State[0].$Object.' ]';
                                            }
                                        }
                                        else
                                        {####
                                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading [ '.$State[0].$Object.' ] Class is not accessible.';
                                        }
                                    }
                                    else
                                    {
                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed Loading Class [ '.$Object.' ].';
                                    }
                                    if($Failed_Loading === False and isset($Class_Object) === True
                                        and is_object($Class_Object) === True
                                        and $Class_Object instanceof ((((String)$State[0]).((String)$Object)))
                                        and $__Object[(String)($Object)][0] = $Class_Object
                                        and $__Object[(String)($Object)][1] = True
                                        and $__Object[(String)($Object)][0] instanceof ((((String)$State[0]).((String)$Object))))
                                    {
                                        $ignore_construction = False;
                                        $_loaded_Classes[] = $__Object;
                                        $Class_Object = Null;
                                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Loaded Class: '.$Object.'.';
                                    }
                                    elseif($Failed_Loading === False
                                        and $__Object[(String)($Object)][0] = ''
                                        and $__Object[(String)($Object)][1] = True)
                                    {
                                        $ignore_construction = False;
                                        $_loaded_Classes[] = $__Object;
                                        $Class_Object = Null;
                                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Loaded Static Class: [ '.$Object.' ].';
                                    }
                                    else
                                    {
                                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed Loading Class [ '.$Object.' ].';
                                    }
                                }
                                else
                                {
                                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed loading [ '.$State[0].$Object.' ] Class not found.';
                                    exit;
                                }
                                unset($Class_Object);
                            }
                            else
                            {
                                unset($required_file);
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed loading requires for [ '.$Object.' ].';
                            }
                        }
                        elseif(isset($State[1]) === True and $State[1] === False)
                        {# Add disabled Object to list.
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Malformed options. Object [ '.$Object.'  ] have not loaded.';
                        }
                        else
                        {# Wrong enabled status type.
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Malformed options. Object [ '.$Object.'  ] have not loaded.';
                        }
                    }
                    else
                    {
                        $the_Object = '';
                        $the_Object = ((String)$Object) ?? '' ?: '';
                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading Object [ '.$the_Object.'  ].';
                    }
                }
                if($ignore_construction === False and isset($this->Class_Objects) === False and isset($this->define_Objects) === True and $this->Class_Objects = $this)
                {
                    $this->is_Object = $_loaded_Classes;
                    $_loaded_Classes = Null;
                    unset($_loaded_Classes);
                    self::$is_Class_Object = $this->Class_Objects;
                    $this->__Object = $__Object;
                    $__Object = Null;
                    unset($__Object);
                }
                elseif($ignore_construction === True)
                {# Do not return Class_Objects instance if construct failed to load every class (Unless specified by user, for load later option with keep classes disabled).
                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Construction of Class_Objects failed. No valid Classes provided.';
                }
            }
        }
        //</editor-fold>
        //<editor-fold desc="Private Variables">
        //<editor-fold desc="Private fail-safe indicators">
        /**
         * @var \iZiTA\Class_Objects
         * Returns the Object of <b>\iZiTA\Class_Objects</b>.
         */
        Private ReadOnly \iZiTA\Class_Objects $Class_Objects;
        /**
         * @var array
         * This ReadOnly array holds the startup arguments.
         */
        Private ReadOnly array $define_Objects;
        /**
         * @var array
         * This array is a dummy shadow array that holds the statuses of the <b>Objects</b> that <b>have loaded</b> successfully at startup.
         */
        Private ReadOnly array $is_Object;
        //</editor-fold>
        //<editor-fold desc="Private Static Variables">
        /**
         * @var ?\iZiTA\Class_Objects
         * Returns the Object of <b>\iZiTA\Class_Objects</b>.
         */
        Private Static ?\iZiTA\Class_Objects $is_Class_Object = Null;
        //</editor-fold>
        //<editor-fold desc="Private Hooked Class Objects [v7]">
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
                        $this->__Class_Name = $Class_Name;
                    }
                }
            }
        /**
         * @var ?array
         * This is the array of objects <b>iZiTA::__Object</b> of the loaded classes.<br>
         * It will be used to access the shared variables and functions inside the classes.<br>
         * It returns the selected object.
         */
        Private ?array $__Object = Null
            {
                get
                {
                    if(isset($this->__Object) === True)
                    {
                        $__Class_Name = $this->__Class_Name ?? Null;
                        if(isset($__Class_Name) === True and empty($__Class_Name) === False and strlen($__Class_Name) > 0)
                        {
                            if(is_object($this->__Object[0][$__Class_Name][0]) === True)
                            {
                                $this->Object_Reference = $this->__Object[0][$__Class_Name][0];
                                return ['1'];
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
                set(?array $_)
                {
                    if(isset($this->__Object) === False)
                    {
                        $this->__Object[] = $_;
                        $_ = Null;
                        unset($_);
                    }
                }
            }
        //</editor-fold>
        //</editor-fold>
        //<editor-fold desc="Functions [v1]">
        //<editor-fold desc="Private Functions">
        Private Function do_Defined(): Void
        {
            echo PHP_EOL.' [ I ] ( Class_Objects )                    do_Defined: Called.';
            if(isset($this->define_Objects) === True and empty($this->define_Objects) === False)
            {
                foreach($this->define_Objects as $Object=>$State)
                {
                    $isset_Object = False;
                    $is_to_Define = False;
                    $is_Object_String = (is_string($Object) ?? False);
                    $isset_Namespace = (isset($State[0]) ?? False);
                    $is_Namespace = (is_string($State[0]) ?? False);
                    $isset_Object = (isset($State[1]) ?? False);
                    $is_to_Define = (is_bool($State[1]) ?? False);
                    if($is_Object_String === True and $isset_Namespace === True and $is_Namespace === True and $isset_Object === True and $is_to_Define === True and $State[1] === True)
                    {
                        if(defined(('>'.((String)$State[0]).((String)$Object))) === True)
                        {
                            exit(' [ ! ] ( Class_Objects )                    do_Defined: Tried to re_define [ '.('>'.((String)$State[0]).((String)$Object)).' ].');
                        }
                        elseif(defined(('>'.((String)$State[0]).((String)$Object))) === False)
                        {
                            $define = define(('>' . ((String)$State[0]).((String)$Object)), False);
                            if($define === True and defined(('>'.((String)$State[0]).((String)$Object))) === True)
                            {
                                echo PHP_EOL.' [ + ] ( Class_Objects )                    do_Defined: Successfully defined [ '.('>'.((String)$State[0]).((String)$Object)).' ].';
                            }
                            else
                            {
                                echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Failed defining [ '.('>'.((String)$State[0]).((String)$Object)).' ].';
                            }
                        }
                    }
                    elseif($is_Object_String === True and $isset_Namespace === True and $is_Namespace === True and $isset_Object === True and $is_to_Define === True and $State[1] === False and defined(('>'.((String)$State[0]).((String)$Object))) === True)
                    {
                        exit(' [ ! ] ( Class_Objects )                    do_Defined: Disabled object is defined '.((String)$Object));
                    }
                }
            }
            else
            {
                echo PHP_EOL.' [ ! ] ( Class_Objects )                    declare_Defines: No objects to define.';
            }
        }
        Private Function check_arguments_case(\ReflectionParameter|\ReflectionProperty $Reflection, array|String|Int|Float|Bool|Null $Argument): Bool
        {
            $is_Parameter = '';
            $is_Parameter = strtolower((String)$Reflection->getType()) ?: '';
            $has_type_Parameter = ($Reflection->hasType() ?? False);
            $Parameter_Type = strtolower(gettype($Argument));
            $Continue = True;
            if(is_array($Argument) === True)
            {
                $flatten_args = $this->Call_Object('Array_library', 'Array_Get_Last', $Argument, '-1');
                if(is_array($flatten_args) === True)
                {
                    foreach($flatten_args as $arg)
                    {
                        switch(True)
                        {
                            case (is_string($arg) === True):
                            case (is_int($arg) === True):
                            case (is_float($arg) === True):
                            case (is_bool($arg) === True):
                            case ($arg === Null):
                            {
                                break;
                            }
                            default:
                            {
                                $Continue = False;
                                break;
                            }
                        }
                        if($Continue === False)
                        {
                            break;
                        }
                    }
                }
            }
            if(isset($is_Parameter) === True and $Continue === True)
            {
                switch(True)
                {
                    case (str_contains($is_Parameter, $Parameter_Type) === True):
                    case (str_contains($is_Parameter, '?') === True and gettype($Argument) === 'NULL' and $Argument === Null):
                    case ($has_type_Parameter === False and (is_array($Argument) === True or is_string($Argument) or is_float($Argument) === True or is_int($Argument) === True or is_bool($Argument) === True or $Argument === Null)):
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
            if(is_array($Arguments) === True and isset($this->is_Object) === True and isset($this->__Object) === True and $this->__Class_Name = $Object_Name and isset($this->__Object) === True)
            {
                $Referred_Class_Grabber = $this->Object_Reference ?? Null;
                if(isset($Referred_Class_Grabber) === True and is_object($Referred_Class_Grabber) === True )
                {
                    if($Referred_Class_Grabber instanceof ((string)("iZiTA\Control_Flow")))
                    {
                        echo PHP_EOL.' ::: ';
                    }
                    $this->Object_Reference = Null;
                    $this->__Class_Name = '';
                    $Object_Name = '';
                    if(method_exists($Referred_Class_Grabber, $Object_Function) === True)
                    {# Perform operation on a function.
                        $is_Method = new \ReflectionMethod($Referred_Class_Grabber, $Object_Function);
                        $is_private = $is_Method->isPrivate() ?? False;
                        $Returned_Error = False;
                        $Return_is_Void = False;
                        $Return = Null;
                        if($is_private === False)
                        {
                            $Pass = False;
                            $is_Parameters = $is_Method->getParameters();
                            if(isset($is_Parameters) === True and count($is_Parameters) > 0 and count($is_Parameters) === count($Arguments))
                            {
                                $args_x = -1;
                                foreach($is_Parameters as $Parameter)
                                {
                                    $args_x += 1;
                                    if($this->check_arguments_case($Parameter, $Arguments[$args_x]) === True)
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
                                if(count($Arguments) === 0)
                                {
                                    $Pass = True;
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
                                elseif(empty($Return) === True or empty($Return) === False)
                                {
                                    if(is_array($Return) === False and is_string($Return) === False and is_float($Return) === False and is_int($Return) === False and is_bool($Return) === False)
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
                            if(is_array($Return) === True)
                            {# Here check array return. Bypass type restricitons.
                            }
                            else
                            {
                                return $Return;
                            }
                        }
                        elseif($is_private === True)
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Cannot access Private Function [ '.$Object_Function.' ].';
                        }
                        elseif($Returned_Error === True)
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing function [ '.$Object_Function.' ], wrong arguments.';
                        }
                        elseif($Return_is_Void === True)
                        {
                            echo PHP_EOL.' [ CO ] ( Class_Objects )                   Void function executed.';
                            return True;
                        }
                        else
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing function [ '.$Object_Function.' ].';
                        }
                    }
                    elseif(property_exists($Referred_Class_Grabber, $Object_Function) === True and isset($Referred_Class_Grabber->$Object_Function) === True)
                    {# Perform operation on a variable.
                        $is_property = new \ReflectionProperty($Referred_Class_Grabber, $Object_Function);
                        $is_property_private = $is_property->isPrivate() ?? False;
                        if($is_property_private === False)
                        {# It is prolly always False because we isset
                            $is_property_static = $is_property->isStatic() ?? False;
                            $Return = Null;
                            if(empty($Arguments) === True)
                            {
                                if($is_property_static === True)
                                {
                                    $Return = $Referred_Class_Grabber::$Object_Function;
                                }
                                else
                                {
                                    $Return = $Referred_Class_Grabber->$Object_Function;
                                }
                            }
                            elseif(count($Arguments) === 1)
                            {
                                if($this->check_arguments_case($is_property, $Arguments[0]) === True)
                                {
                                    if($is_property_static === True)
                                    {
                                        $Return = True;
                                        $Referred_Class_Grabber::$Object_Function = $Arguments[0];
                                    }
                                    else
                                    {
                                        $Return = True;
                                        $Referred_Class_Grabber->$Object_Function = $Arguments[0];
                                    }
                                }
                                else
                                {
                                    echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Unsupported variable call.';
                                }
                            }
                            else
                            {
                                echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Malformed arguments for Object [ '.$Object_Name.' ].';
                            }
                            if(isset($Return) === True)
                            {
                                if(is_array($Return) === True)
                                {
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
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Cannot access Private Property [ '.$Object_Function.' ].';
                        }
                    }
                    else
                    {
                        echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing call to non-existent method or object [ '.$Object_Name.$Object_Function.' ].';
                    }
                }
                else
                {
                    echo PHP_EOL.' [ !!CO ] ( Class_Objects )                 Error: Object [ '.$Object_Name.' ] does not exist.';
                }
            }
            else
            {
                echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Object [ '.$Object_Name.' ] does not exist.';
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
         * Returns <b>`False`</b> if there is an error with the execution.
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
