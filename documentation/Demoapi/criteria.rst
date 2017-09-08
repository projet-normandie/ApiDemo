===================
Criteria parameters
===================

For some actions, it is possible to define in the request a parameter called *"criteria"* that takes or gives more
specific information regarding the action.

As this parameter can provide a huge amount of possibilities, it is also a bit complex, so we decided to document it
here.

Criteria
--------

Presentation
~~~~~~~~~~~~

A *"criteria"* parameter is composed of **one** or **several** operations called *criterion*.

In case of several *criterion* used, you will need to group them by using aggregator which are *logical operators*.

But for a simple *criterion*, the usage is simpler.


Single Criterion
~~~~~~~~~~~~~~~~

A *criterion* is mainly composed of 3 fields:

    field
        *Name of the database field(s) the criterion will be applied.*

        The field is upon your database field names for your accessible entities.

    operator
        *Name of the operator of the criterion.*

        The list of available operators is detailed below.

    value
        *Value(s) that will be applied to the given operator for the given field(s).*

        Values are up to you and up to what you need to focus on the criterion.

For example, if you want a *criterion* representing all your "phoneNumber" starting with "+1-555", you will define such
*criterion* (for ORM-like databases):

    ::

        {"field": "phoneNumber", "operator": "like", "value": "+1-555%"}

Aggregation of Criteria
~~~~~~~~~~~~~~~~~~~~~~~

For several *criterion*, you will need to aggregate them using *logical operators*.

For example, if you want to make a *criterion* that represents all your "lastName" starting with "S" **AND** "sex" is
exactly "F", you will define such *criterion* (for ORM-like databases):

    ::

        {
            "and":[
                {"field": "lastName", "operator": "like", "value": "S%"},
                {"field": "sex", "operator": "=", "value": "F"}
            ]
        }

Going deeper with aggregations
++++++++++++++++++++++++++++++

As an aggregation of criteria is considered as a *criterion*, you can be even more precise and combine aggregations
between them!

Let's see:

    ::

        {
            "or":[
                {
                    "and":[
                        {"field": "lastName", "operator": "like", "value": "S%"},
                        {"field": "sex", "operator": "=", "value": "F"}
                    ]
                },
                {
                    "xor":[
                        {"field": "firstName", "operator": "like", "value": "%John%"},
                        {
                            "not":[
                                {"field": "sex", "operator": "=", "value": "M"}
                            ]
                        }
                    ]
                }
            ]
        }

.. note::
    Now you can see how powerful the system is, you can make any criteria you need!

Operators
---------

Presentation
~~~~~~~~~~~~

The most important part of a *criterion* is the "operator" field, as it can change the structure of your "field"
parameter or your "value" parameter.

.. note::
    A good example for this is the operator "between", that must, of course, take 2 "values".

You will find a list of "operators" split in 2 groups: *operators* and *logical operators*.

Operators list
~~~~~~~~~~~~~~

    Operator **=**
        This operator takes **1 field** and **1 value**.

        Checks the equality between the given value and all values found for the given field.

        Ex: ``{"field": "sex", "operator": "=", "value": "F"}``

    Operator **!=**
        This operator takes **1 field** and **1 value**.

        Checks the non-equality between the given value and all values found for the given field.

        Ex: ``{"field": "lastName", "operator": "!=", "value": "Doe"}``

    Operator **<**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field are strictly less than the given value.

        Ex: ``{"field": "salary", "operator": "<", "value": 1000.00}``

    Operator **<=**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field are less or equal than the given value.

        Ex: ``{"field": "salary", "operator": "<=", "value": 1500.00}``

    Operator **>**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field are strictly greater than the given value.

        Ex: ``{"field": "age", "operator": ">", "value": 35}``

    Operator **>=**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field are greater or equal than the given value.

        Ex: ``{"field": "age", "operator": ">=", "value": 52}``

    Operator **like**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field match the SQL pattern given in the value.

        Ex: ``{"field": "firstName", "operator": "like", "value": "Jo%"}``

    Operator **not like**
        This operator takes **1 field** and **1 value**.

        Checks all values found for the given field do not match the SQL pattern given in the value.

        Ex: ``{"field": "firstName", "operator": "not like", "value": "J%a%"}``

    Operator **is null**
        This operator takes **1 field**.

        Checks all values found for the given field are ``NULL``.

        Ex: ``{"field": "awards", "operator": "is null"}``

    Operator **is not null**
        This operator takes **1 field**.

        Checks all values found for the given field are not ``NULL``.

        Ex: ``{"field": "awards", "operator": "is not null"}``

    Operator **in**
        This operator takes **1 field** and **1 or more values**.

        Checks all values found for the given field are matching a list of authorized given values.

        Ex: ``{"field": "sex", "operator": "in", "value": ["M", "F", "L", "G", "B", "T"]}``

    Operator **not in**
        This operator takes **1 field** and **1 or more values**.

        Checks all values found for the given field are not matching a list of unauthorized given values.

        Ex: ``{"field": "sex", "operator": "not in", "value": ["M", "F"]}``

    Operator **between**
        This operator takes **1 field** and **exactly 2 values**.

        Checks all values found for the given field are in the range bounded by the 2 given values
        (using a opened comparison).

        Ex: ``{"field": "birthDate", "operator": "between", "value": ["1972-05-04", "1975-06-24"]}``

    Operator **not between**
        This operator takes **1 field** and **exactly 2 values**.

        Checks all values found for the given field are not in the range bounded by the 2 given values
        (using a opened comparison).

        Ex: ``{"field": "birthDate", "operator": "not between", "value": ["1989-06-17", "1999-04-30"]}``

    Operator **plane distance**
        This operator takes **exactly 2 fields** and **exactly 3 values**.
        Fields must be declared as an object containing the properties **x** and **y**.
        Values must be declared as an object containing the properties **x**, **y** and **distance**.

        Checks all coordinates found for the given fields are in a range distance of the given **distance** value,
        when using the coordinates **x** and **y** given in the "value" field.

        This distance is calculated upon a plane according to the Euclidian geometry.
        *It can not be used to calculate distances between two coordinates on Earth, as this kind of calculus is not based upon the Euclidian geometry.*

        Ex: ``{"field": {"x": xPosition, "y": yPosition}, "operator": "plane distance", "value": {"x": 49.4, "y": 72.65, "distance": 500}}``

    Operator **space distance**
        This operator takes **exactly 3 fields** and **exactly 4 values**.
        Fields must be declared as an object containing the properties **x**, **y** and **z**.
        Values must be declared as an object containing the properties **x**, **y**, **z** and **distance**.

        Checks all coordinates found for the given fields are in a range distance of the given **distance** value,
        when using the coordinates **x**, **y** and **z** given in the "value" field.

        This distance is calculated upon a space according to the Euclidian geometry.
        *It can not be used to calculate distances between two coordinates on Earth, as this kind of calculus is not based upon the Euclidian geometry.*

        Ex: ``{"field": {"x": xPosition, "y": yPosition, "z": zPosition}, "operator": "space distance", "value": {"x": 39.3, "y": 178.4, "z": -47.1, "distance": 750}}``

Logical operators list
~~~~~~~~~~~~~~~~~~~~~~

    Operator **not**
        This operator takes **an array of exactly 1 criterion**.

        Inverts the checking of the given criterion.

        Ex: ``{"not": [{"field": "birthDate", "operator": "like", "value": "1989%"}]}``

    Operator **or**
        This operator takes **an array of 2 or more criteria**.

        Checks at least 1 of the given criteria is satisfied.

        Ex: ``{"or": [{"field": "lastName", "operator": "=", "value": "Doe"}, {"field": "firstName", "operator": "!=", "value": "John"}]}``

    Operator **and**
        This operator takes **an array of 2 or more criteria**.

        Checks all given criteria are satisfied.

        Ex: ``{"and": [{"field": "lastName", "operator": "=", "value": "Connor"}, {"field": "firstName", "operator": "=", "value": "Sarah"}]}``

    Operator **xor**
        This operator takes **an array of exactly 2 criteria**.

        Checks only 1 criterion but not both given criteria is satisfied.

        Ex: ``{"xor": [{"field": "sex", "operator": "=", "value": "M"}, {"field": "firstName", "operator": "!=", "value": "Sarah"}]}``

    Operator **implicates**
        This operator takes **an array of exactly 2 criteria**.

        Checks the first criterion implicates the second criterion.
        This operation is the same as ``NOT(a) OR b``.

        Ex: ``{"implicates": [{"field": "awards", "operator": ">", "value": 5}, {"field": "birthDate", "operator": "like", "value": "%-06-04"}]}``

    Operator **equates**
        This operator takes **an array of exactly 2 criteria**.

        Checks the first criterion respects the second criterion.
        This operation is the same as ``NOT(a XOR b)``.

        Ex: ``{"equates": [{"field": "sex", "operator": "!=", "value": "M"}, {"field": "lastName", "operator": "!=", "value": "John"}]}``

    Operator **inhibition**
        This operator takes **an array of exactly 2 criteria**.

        Checks the first criterion inhibits the second criterion.
        This operation is the same as ``a AND NOT(b)``.

        Ex: ``{"inhibition": [{"field": "awards", "operator": ">", "value": 5}, {"field": "birthDate", "operator": "like", "value": "%-06-04"}]}``
