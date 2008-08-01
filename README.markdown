
## Features

* Function Autocompletion (`⌥⎋`) - for a given function name prefix, let's you select a function, a specific interface (combination of parameters), and returns a customised snippet with each argument a tab stop
* Align Assignments (`⌥⌘]`) - for the current block or select block of code, all := assignment operators are aligned on the same column
* New Function (`funct`) - creates the complete stub for a new EPM function, including large comment header; within the parameter parentheses you can create const and variable parameters with `const` and `var` snippets
* Parameter Comments (`⌃⌥P`) - replaces PARAMETERS: comment block with stubs for current function parameters

## Required setup

Environment variables:

* `SV_USER` or `USER` - e.g. drnic (your CB login)
* `SV_ORGANIZATION_NAME` - e.g. Intec Billing Pty Ltd (the company that copyrights your source)

## Windows

* Need to test that Function Autocompletion works with TextMate::UI.menu - may need a downgrade option for E Text Editor

## Ideas

* In function comment headers add a REMOTE: block to describe the remote settings of a function, if applicable. Allow this block to be generated for pre-existing functions
* Function name helper - a widget to help with function name namespacing (see Developers Guide)
* Function search
* Function tagging (useful for search) - use atlanta_group?
* Validate EPM
* Reformat EPM
