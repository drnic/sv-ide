
## Features

* Function Autocompletion (`⌥⎋`) - for a given function name prefix, let's you select a function, a specific interface (combination of parameters), and returns a customised snippet with each argument a tab stop
* Align Assignments (`⌥⌘]`) - for the current block or select block of code, all := assignment operators are aligned on the same column
* New Function (`func`) - creates the complete stub for a new EPM function, including large comment header; within the parameter parentheses you can create const and variable parameters with `const` and `var` snippets
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
* Reformat SQL concatted string for SQLQuery?[] calls (e.g. `fTT_LegalEntities?[]`)
* Reformat function calls with many arguments over multiple lines (see `fTT_PRD_List_CustProducts?[]` call in `fTT_MSG_AddAttributes_Lists&`)

* QuickSilver/TextMate Selector via HTML+JS - not sure how a selection within HTML can be picked back up via TextMate. Via txmt protocol?

* Multiple EPM functions on a single page, esp if they are small. Perhaps Alt+G -> open in new file, Shift+Alt+G -> open below current function
	* Functions shown below the main function could be read-only. Perhaps "on save to SV" it could validate that you haven't modified them in any way, or offer to save those changes too.
	* Only include small portion of header for the 2+ function in a file

