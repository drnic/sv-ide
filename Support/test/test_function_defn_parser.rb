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
      assert_equal(%w[c_ConstName& l_VarName&], parser.parameters)
    end
  end
  
end
