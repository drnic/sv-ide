
## Features

* Function Autocompletion (`⌥⎋`) - for a given function name prefix, let's you select a function, a specific interface (combination of parameters), and returns a customised snippet with each argument a tab stop
* Align Assignments (`⌥⌘]`) - for the current block or select block of code, all := assignment operators are aligned on the same column
* New Function (`func`) - creates the complete stub for a new EPM function, including large comment header; within the parameter parentheses you can create const and variable parameters with `const` and `var` snippets
* Parameter Comments (`⌃⌥P`) - replaces PARAMETERS: comment block with stubs for current function parameters

## Required setup

Environment variables:

* `SV_USER` or `USER` - e.g. drnic (your CB login)
* `SV_ORGANIZATION_NAME` - e.g. Intec Billing Pty Ltd (the company that copyrights your source)

### Add variable/function type characters as official characters of words

On TextMate:

* Open Preferences
* Click "Text Editing"
* Change "Word Characters" to: `_@#$&~{}[]`

For example:

<div class="thumbnail"><a href="http://skitch.com/drnic/1t3j/variable-type-characters-as-word-characters"><img src="http://img.skitch.com/20080805-ph62qqmbqghugeigsia272u5p9.preview.jpg" alt="Variable type characters as word characters" /></a></div>


## Windows

* Need to test that Function Autocompletion works with TextMate::UI.menu - may need a downgrade option for E Text Editor

## Ideas

* In function comment headers add a REMOTE: block to describe the remote settings of a function, if applicable. Allow this block to be generated for pre-existing functions
	* Or reuse the eccs .epm header format
* Function name helper - a widget to help with function name namespacing (see Developers Guide)
* Function search and generate snippet with tab stops for arguments
* Function tagging (useful for search) - use atlanta_group?
* Validate EPM (perhaps using FunctionParse&)
* Reformat EPM
* Reformat SQL concatted string for SQLQuery?[] calls (e.g. `fTT_LegalEntities?[]` or `fTT_NonDebitMemoElig&`)
* Reformat function calls with many arguments over multiple lines (see `fTT_PRD_List_CustProducts?[]` call in `fTT_MSG_AddAttributes_Lists&`)
* Reformat function parameter declarations over multiple lines (e.g. `fTT_MSG_AddAttributes_Lists&`)
* abort(id, [args]) - a Command to select error msg from list and generate snippet with tab stops
* abort(id, ...) - "Go to Error Message" Command

* QuickSilver/TextMate Selector via HTML+JS - not sure how a selection within HTML can be picked back up via TextMate. Via txmt protocol?

* Multiple EPM functions on a single page, esp if they are small. Perhaps Alt+G -> open in new file, Shift+Alt+G -> open below current function
	* Functions shown below the main function could be read-only. Perhaps "on save to SV" it could validate that you haven't modified them in any way, or offer to save those changes too.
	* Only include small portion of header for the 2+ function in a file

