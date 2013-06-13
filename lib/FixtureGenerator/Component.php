<?php

namespace FixtureGenerator;

    /**
     * This file contains the foundation classes for component-based programming.
     *
     * @author Igor Gaponov <jiminy96@gmail.com>
     */

/**
 * CComponent is the base class for all components.
 *
 * CComponent implements the protocol of defining, using properties and events.
 *
 * A property is defined by a getter method, and/or a setter method.
 * Properties can be accessed in the way like accessing normal object members.
 * Reading or writing a property will cause the invocation of the corresponding
 * getter or setter method, e.g
 * <pre>
 * $a=$component->text;     // equivalent to $a=$component->getText();
 * $component->text='abc';  // equivalent to $component->setText('abc');
 * </pre>
 * The signatures of getter and setter methods are as follows,
 * <pre>
 * // getter, defines a readable property 'text'
 * public function getText() { ... }
 * // setter, defines a writable property 'text' with $value to be set to the property
 * public function setText($value) { ... }
 * </pre>
 *
 * An event is defined by the presence of a method whose name starts with 'on'.
 * The event name is the method name. When an event is raised, functions
 * (called event handlers) attached to the event will be invoked automatically.
 *
 * An event can be raised by calling {@link raiseEvent} method, upon which
 * the attached event handlers will be invoked automatically in the order they
 * are attached to the event. Event handlers must have the following signature,
 * <pre>
 * function eventHandler($event) { ... }
 * </pre>
 * where $event includes parameters associated with the event.
 *
 * To attach an event handler to an event, see {@link attachEventHandler}.
 * You can also use the following syntax:
 * <pre>
 * $component->onClick=$callback;    // or $component->onClick->add($callback);
 * </pre>
 * where $callback refers to a valid PHP callback. Below we show some callback examples:
 * <pre>
 * 'handleOnClick'                   // handleOnClick() is a global function
 * array($object,'handleOnClick')    // using $object->handleOnClick()
 * array('Page','handleOnClick')     // using Page::handleOnClick()
 * </pre>
 *
 * To raise an event, use {@link raiseEvent}. The on-method defining an event is
 * commonly written like the following:
 * <pre>
 * public function onClick($event)
 * {
 *     $this->raiseEvent('onClick',$event);
 * }
 * </pre>
 * where <code>$event</code> is an instance of {@link CEvent} or its child class.
 * One can then raise the event by calling the on-method instead of {@link raiseEvent} directly.
 *
 * Both property names and event names are case-insensitive.
 *
 * CComponent supports behaviors. A behavior is an
 * instance of {@link IBehavior} which is attached to a component. The methods of
 * the behavior can be invoked as if they belong to the component. Multiple behaviors
 * can be attached to the same component.
 *
 * To attach a behavior to a component, call {@link attachBehavior}; and to detach the behavior
 * from the component, call {@link detachBehavior}.
 *
 * A behavior can be temporarily enabled or disabled by calling {@link enableBehavior}
 * or {@link disableBehavior}, respectively. When disabled, the behavior methods cannot
 * be invoked via the component.
 *
 * Starting from version 1.1.0, a behavior's properties (either its public member variables or
 * its properties defined via getters and/or setters) can be accessed through the component it
 * is attached to.
 *
 * @author Igor Gaponov <jiminy96@gmail.com>
 */
abstract class Component
{
    /**
     * Returns a property value.
     * @param string $name the property name
     * @return mixed the property value
     * @throws Exception if the property is not defined
     * @see __set
     */
    public function __get($name)
    {
        $getter='get'.$name;
        if(method_exists($this,$getter))
            return $this->$getter();
        $class = get_class();
        throw new Exception("Property {$class}.{$name} is not defined.");
    }

    /**
     * Sets value of a component property.
     * @param string $name the property name
     * @param mixed $value the property value
     * @return mixed
     * @throws Exception if the property is not defined or the property is read only.
     * @see __get
     */
    public function __set($name,$value)
    {
        $setter='set'.$name;
        if(method_exists($this,$setter))
            return $this->$setter($value);
        $class = get_class();
        if(method_exists($this,'get'.$name))
            throw new Exception("Property {$class}.{$name} is read only.");
        else
            throw new Exception("Property {$class}.{$name} is not defined.");
    }

    /**
     * Initializes the component.
     * This method is called after construction of component.
     * You may override this method to perform the needed initialization for the component.
     */
    public function init()
    {

    }

    /**
     * Evaluates a PHP expression or callback under the context of this component.
     *
     * Valid PHP callback can be class method name in the form of array, or anonymous function.
     *
     * @param mixed $expression a PHP expression or PHP callback to be evaluated.
     * @param array $data additional parameters to be passed to the above expression/callback.
     * @return mixed the expression result
     */
    public function evaluate($expression, $data)
    {
        if (is_string($expression)) {
            extract($data);
            return eval('return ' . $expression . ';');
        } else {
            return call_user_func_array($expression, $data);
        }
    }
}
