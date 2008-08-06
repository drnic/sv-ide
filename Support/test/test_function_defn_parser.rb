require File.dirname(__FILE__) + "/test_helper"

require "function_defn_parser"
class Context
  def should_have_name(name)
    should "have name #{name.inspect}" do
      assert_equal(name, parser.name)
    end
  end
  def should_have_parameters(parameters)
    should "have parameters #{parameters.inspect}" do
      assert_equal(parameters, parser.parameters)
    end
  end
  def should_have_no_parameters
    should "have no parameters" do
      assert_equal([], parser.parameters)
    end
  end
  def should_have_signature(signature)
    should "have signature #{signature.inspect}" do
      assert_equal(signature, parser.signature)
    end
  end
end

class TestFunctionDefnParser < Test::Unit::TestCase
  attr_reader :parser
  
  context "function with several parameters" do
    setup do
      file    = fixtures_dir + "/epm_functions/PretendFunctions/function_with_several_parameters.epm"
      lines   = File.readlines(file)
      @parser = FunctionDefnParser.new(lines)
    end

    should_have_name "fYourFunctionName&"
    should_have_parameters ["c_ConstName&", "l_VarName&", "c_SomeDates~[]", 'c_Hash#{}']
    should_have_signature 'fYourFunctionName&(const c_ConstName&, var l_VarName&, const c_SomeDates~[], const c_Hash#{})'
  end
  
  context "function with complex return type" do
    setup do
      function = <<-LINES
fTT_DoSomething?{}() = 
{
  return 1;
}
      LINES
      @parser = FunctionDefnParser.new(function.split("\n"))
    end

    should_have_name "fTT_DoSomething?{}"
    should_have_no_parameters
    should_have_signature 'fTT_DoSomething?{}()'
  end
  
  context "function with multi-line signature" do
    setup do
      function = <<-LINES
fTT_PRD_List_CustProducts?[](const l_CustomerNodeId&
                           , const l_EffectiveDate~
                           , const c_PrdInstStsList?[]
                           , const c_ReturnFormat$
                           , const c_ReturnCLP&) = {
  # do things
}
      LINES
      @parser = FunctionDefnParser.new(function.split("\n"))
    end

    should_have_name "fTT_PRD_List_CustProducts?[]"
    should_have_parameters ["l_CustomerNodeId&", "l_EffectiveDate~", "c_PrdInstStsList?[]",
        "c_ReturnFormat$", "c_ReturnCLP&"]
    should_have_signature 'fTT_PRD_List_CustProducts?[](const l_CustomerNodeId&, const l_EffectiveDate~, ' +
      'const c_PrdInstStsList?[], const c_ReturnFormat$, const c_ReturnCLP&)'
  end
  
  context "function with comments for each parameter" do
    setup do
      function = <<-LINES
# SOURCE
SQLQuery?[](
    const SQLText$,        # SQL statement to execute
    const ParamNames$[],  # Names of parameters in statement
    const ParamValues?[])  # Values to pass to parameters
= 
{
    # SQLQuery?[]() is a built-in function which when executed within an appropriate server, executes the 
    # statement locally.  In cases where the SQLQuery?[]() function is not built-in, default to calling the
    # remote version.  This means configurers can always call SQLQuery?[]() in any environment and expect 
    # it to execute ok.

    biSQLQuery?[](SQLText$, ParamNames$[], ParamValues?[]);
}
      LINES
      file    = fixtures_dir + "/epm_functions/Local/SQLQuery-unknownarray-1.epm"
      lines   = File.readlines(file)
      @parser = FunctionDefnParser.new(lines)
      # @parser = FunctionDefnParser.new(function.split("\n"))
    end

    should_have_name "SQLQuery?[]"
    should_have_parameters ["SQLText$", "ParamNames$[]", "ParamValues?[]"]
    should_have_signature 'SQLQuery?[](const SQLText$, const ParamNames$[], const ParamValues?[])'
  end
  
  context "function with parameters starting on next line" do
    setup do
      file    = fixtures_dir + "/epm_functions/Local/ReferenceCodeValidate-integer-1.epm"
      lines   = File.readlines(file)
      @parser = FunctionDefnParser.new(lines)
    end

    should_have_name "ReferenceCodeValidate&"
    should_have_parameters ["ReferenceTypeLabel$", "ReferenceCode&", "FieldName$"]
    should_have_signature 'ReferenceCodeValidate&(const ReferenceTypeLabel$, const ReferenceCode&, const FieldName$)'
  end
  
  context "function with inbound var parameter" do
    setup do
      function = <<-LINES
ReferenceCodeAbbrev$(const ReferenceTypeAbbrev$, ReferenceCode&) = 
{   # If called from client, call remote function
    biReferenceCodeAbbrev$(ReferenceTypeAbbrev$, ReferenceCode&);
}
      LINES
      @parser = FunctionDefnParser.new(function.split("\n"))
    end

    should_have_name "ReferenceCodeAbbrev$"
    should_have_parameters ["ReferenceTypeAbbrev$", "ReferenceCode&"]
    should_have_signature 'ReferenceCodeAbbrev$(const ReferenceTypeAbbrev$, ReferenceCode&)'
  end
  
end
