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
     * Script version: <b>202604.5.7.71</b><br>
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
            }elseif(empty($Classes) === False and isset(self::$is_Class_Object) === False and isset($this->define_Objects) === False and isset($this->Class_Objects) === False)
            {
                $this->define_Objects = $Classes;
                if(isset($this->define_Objects) === True)
                {
                    echo PHP_EOL.' [ +I ] ( Class_Objects )                   Defines declared successfully.';
                }else
                {
                    echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed to declare defines.';
                }
                $this->do_Defined();
                $__Object = Null;
                $_loaded_Classes = [];
                foreach($Classes as $Object=>$State)
                {
                    if(is_string($Object) === True and isset($State[0]) === True and is_string($State[0]) === True and isset($State[1]) === True and $State[1] === True)
                    {
                        echo PHP_EOL.' [ I ] ( Class_Objects )                    Loading '.$State[0].((String)$Object).'.';
                        $required_file = ((String)$Object).'.php';
                        $is_file = False;
                        if(is_file($required_file) === True)
                        {
                            $is_file = (Bool)(Require $required_file) ?? False;
                        }else
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading [ '.$Object.'.php ], file not found.';
                        }
                        if($is_file === True)
                        {
                            $Class_Object = Null;
                            if(class_exists((((String)$State[0]).((String)$Object)), False) === True
                                and enum_exists((((String)$State[0]).((String)$Object)), False) === False
                                and (isset($State[2]) === True
                                    ? (is_string($State[2]) === True
                                        ? $Class_Object = ((((String)$State[0]).((String)$Object)))::{$State[2]}(...$State[3] ?? [''])
                                        : exit(' [ !I ] ( Class_Objects )                   '.(((String)$State[0]).((String)$Object)).'Invalid class call.')
                                    )
                                    : $Class_Object = new ((((String)$State[0]).((String)$Object)))
                                )
                                and isset($Class_Object) === True
                                and is_object($Class_Object) === True
                                and $Class_Object instanceof ((((String)$State[0]).((String)$Object)))
                                and $__Object[(String)($Object)][0] = $Class_Object
                                and $__Object[(String)($Object)][1] = True
                                and $__Object[(String)($Object)][0] instanceof ((((String)$State[0]).((String)$Object))))
                            {
                                $_loaded_Classes[] = $Object;
                                $Class_Object = Null;
                                echo PHP_EOL.' [ I ] ( Class_Objects )                    Loaded '.$Object.'.';
                            }else
                            {
                                echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading '.$Object.' THE FATHER.';
                                exit;
                            }
                            unset($Class_Object);
                        }else
                        {
                            echo PHP_EOL.' [ !I ] ( Class_Objects )                   Error: Failed loading requires for [ '.$Object.' ].';
                        }
                    }else
                    {
                        $the_Object = '';
                        $the_Object = ((String)$Object) ?? '' ?: '';
                        echo PHP_EOL.' [ !I ] ( Class_Objects )                   Failed loading Object [ '.$the_Object.'  ].';
                    }
                }
                if(isset($this->Class_Objects) === False and isset($this->define_Objects) === True and $this->Class_Objects = $this)
                {
                    $this->is_Object = $_loaded_Classes;
                    $_loaded_Classes = Null;
                    unset($_loaded_Classes);
                    self::$is_Class_Object = $this->Class_Objects;
                    $this->__Object = $__Object;
                    $__Object = Null;
                    unset($__Object);
                }
            }
        }
        //</editor-fold>
        //<editor-fold desc="Private Variables">
        //<editor-fold desc="Private fail-safe indicators [v4]">
        /**
         * @var \iZiTA\Class_Objects
         * Returns the Object of <b>\iZiTA\Class_Objects</b>.
         */
        Private ReadOnly \iZiTA\Class_Objects $Class_Objects;
        /**
         * @var array
         * This array is.
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
                            }else
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
                        }elseif(defined(('>'.((String)$State[0]).((String)$Object))) === False)
                        {
                            $define = define(('>' . ((String)$State[0]).((String)$Object)), False);
                            if($define === True and defined(('>'.((String)$State[0]).((String)$Object))) === True)
                            {
                                echo PHP_EOL.' [ + ] ( Class_Objects )                    do_Defined: Successfully defined [ '.('>'.((String)$State[0]).((String)$Object)).' ].';
                            }else
                            {
                                echo PHP_EOL.' [ ! ] ( Class_Objects )                    do_Defined: Failed defining [ '.('>'.((String)$State[0]).((String)$Object)).' ].';
                            }
                        }
                    }elseif($is_Object_String === True and $isset_Namespace === True and $is_Namespace === True and $isset_Object === True and $is_to_Define === True and $State[1] === False and defined(('>'.((String)$State[0]).((String)$Object))) === True)
                    {
                        exit(' [ ! ] ( Class_Objects )                    do_Defined: Disabled object is defined '.((String)$Object));
                    }
                }
            }else
            {
                echo PHP_EOL.' [ ! ] ( Class_Objects )                    declare_Defines: No objects to define.';
            }
        }

        /**
         * Calls a specified method or accesses/modifies a property of an object by dynamically resolving the object reference.
         * @param string $Object_Name The name of the target object ( Class ) to operate on.
         * @param string $Object_Function The name of the method to invoke or the property to access/modify.
         * @param mixed ...$Arguments Optional arguments to pass to the method or to assign to the property.
         * @return bool|string|int|array
         * Returns the result of the method invocation or property value modification.
         * Returns <b>`True`</b> if a void function is executed successfully.
         * Returns <b>`False`</b> if there is an error in the execution.
         */
        Private Function Call_Object(String $Object_Name, String $Object_Function, ...$Arguments): Bool|String|Int|array
        {
            if(is_array($Arguments) === True and isset($this->is_Object) === True and isset($this->__Object) === True and $this->__Class_Name = $Object_Name and isset($this->__Object) === True)
            {
                $Referred_Class_Grabber = $this->Object_Reference ?? Null;
                if(isset($Referred_Class_Grabber) === True and is_object($Referred_Class_Grabber) === True)
                {
                    $this->Object_Reference = Null;
                    $this->__Class_Name = '';
                    if(method_exists($Referred_Class_Grabber, $Object_Function) === True)
                    {# Perform operation on a function.
                        $Returned_Error = False;
                        $Return_is_Void = False;
                        $Return = Null;
                        if(empty($Arguments) === False)
                        {
                            $Return = $Referred_Class_Grabber->$Object_Function(...$Arguments);
                        }elseif(empty($Arguments) === True)
                        {
                            $Return = $Referred_Class_Grabber->$Object_Function();
                        }
                        if($Return === Null)
                        {
                            $Return_is_Void = True;
                        }elseif(empty($Return) === True or empty($Return) === False)
                        {
                            if(is_array($Return) === False and is_string($Return) === False and is_int($Return) === False and is_bool($Return) === False)
                            {
                                $Returned_Error = True;
                            }
                        }
                        if($Return !== Null and $Returned_Error === False)
                        {
                            return $Return;
                        }elseif($Returned_Error === True)
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing function ['.$Object_Function.'], wrong arguments.';
                        }elseif($Return_is_Void === True)
                        {
                            echo PHP_EOL.' [ CO ] ( Class_Objects )                   Void function executed.';
                            return True;
                        }else
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing function ['.$Object_Function.'].';
                        }
                    }elseif(property_exists($Referred_Class_Grabber, $Object_Function) === True and isset($Referred_Class_Grabber->$Object_Function) === True)
                    {# Perform operation on a variable.
                        if(empty($Arguments) === True)
                        {
                            return $Referred_Class_Grabber->$Object_Function;
                        }elseif(count($Arguments) === 1)
                        {
                            $is_Property_Type = Null;
                            $is_Property_Type = gettype($Referred_Class_Grabber->$Object_Function) ?? Null;
                            switch(True)
                            {
                                case is_array($is_Property_Type) === True and (is_array($Arguments[0]) === True or $Arguments[0] === Null):
                                case is_string($is_Property_Type) === True and (is_string($Arguments[0]) === True or $Arguments[0] === Null):
                                case is_int($is_Property_Type) === True and (is_int($Arguments[0]) === True or $Arguments[0] === Null):
                                case is_bool($is_Property_Type) === True and (is_bool($Arguments[0]) === True or $Arguments[0] === Null):
                                {
                                    $Referred_Class_Grabber->$Object_Function = $Arguments[0];
                                    return True;
                                }
                                default:
                                    echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Variable call is not supported.';
                            }
                        }else
                        {
                            echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Malformed arguments for Object ['.$Object_Name.']';
                        }
                    }else
                    {
                        echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Failed executing call to non-existent method or object ['.$Object_Name.$Object_Function.']';
                    }
                }else
                {
                    echo PHP_EOL.' [ !!CO ] ( Class_Objects )                 Error: Object [ '.$Object_Name.' ] does not exist.';
                }
            }else
            {
                echo PHP_EOL.' [ !CO ] ( Class_Objects )                  Error: Object [ '.$Object_Name.' ] does not exist.';
            }
            return False;
        }
        //</editor-fold>
        //<editor-fold desc="Final Functions">
        Final Static Function isset_Call_Object(): Bool
        {
            if(isset(self::$is_Class_Object) === True and self::$is_Class_Object instanceof \iZiTA\Class_Objects)
            {
                return True;
            }
            return False;
        }
        Final Static Function Call_Object_Handler(String $Object_Name, String $Object_Function, ...$Arguments): Bool|String|Int|array|Null
        {
            if(isset(self::$is_Class_Object) === True)
            {
                return self::$is_Class_Object->Call_Object($Object_Name, $Object_Function, ...$Arguments);
            }else
            {
                return Null;
            }
        }
        //</editor-fold>
        //</editor-fold>
    }
}?>
