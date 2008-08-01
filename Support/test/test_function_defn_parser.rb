require File.dirname(__FILE__) + "/test_helper"

require "function_defn_parser"

class TestFunctionDefnParser < Test::Unit::TestCase
  attr_reader :parser
  
  context "function with several parameters" do
    setup do
      file    = fixtures_dir + "/function_defns/function_with_several_parameters.epm"
      lines   = File.readlines(file)
      @parser = FunctionDefnParser.new(lines)
    end

    should "find name" do
      assert_equal("fYourFunctionName&", parser.name)
    end

    should "find paramters" do
      assert_equal(["c_ConstName&", "l_VarName&", "c_SomeDates~[]", 'c_Hash#{}'], parser.parameters)
    end
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

    should "find name" do
      assert_equal("fTT_DoSomething?{}", parser.name)
    end
    
    should "have no paramters" do
      assert_equal([], parser.parameters)
    end
  end
  
end
