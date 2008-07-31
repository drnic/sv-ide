require File.dirname(__FILE__) + "/test_helper"

require "parameter_comments"

class TestParameterComments < Test::Unit::TestCase
  context "function with several parameters" do
    setup do
      file          = fixtures_dir + "/function_defns/function_with_several_parameters.epm"
      lines         = File.readlines(file)
      @result_doc   = ParameterComments.new.run(lines)
      @result_lines = @result_doc.split("\n")
    end

    should "replace PARAMETER block with comment stubs" do
      assert_equal("# PARAMETERS:", @result_lines[24])
      assert_equal("#   c_ConstName& - TODO", @result_lines[25])
      assert_equal("#   l_VarName& - TODO", @result_lines[26])
      assert_equal("#", @result_lines[27])
    end
    
    should "still have RETURNS section" do
      assert_equal("# RETURNS:", @result_lines[28])
    end
  end
  
  context "function with no parameters" do
    setup do
      file          = fixtures_dir + "/function_defns/function_with_no_parameters.epm"
      lines         = File.readlines(file)
      @result_doc   = ParameterComments.new.run(lines)
      @result_lines = @result_doc.split("\n")
    end

    should "replace PARAMETER block with comment stubs" do
      assert_equal("# PARAMETERS:", @result_lines[24])
      assert_equal("#   None", @result_lines[25])
      assert_equal("#", @result_lines[26])
    end
  end
  
  context "function with several parameters but some already commented" do
    setup do
      file          = fixtures_dir + "/function_defns/function_with_several_parameters_and_some_param_comments.epm"
      lines         = File.readlines(file)
      @result_doc   = ParameterComments.new.run(lines)
      @result_lines = @result_doc.split("\n")
    end

    should "replace PARAMETER block with comment stubs but protect existing comments" do
      assert_equal("# PARAMETERS:", @result_lines[24])
      assert_equal("#   c_ConstName1& - TODO", @result_lines[25])
      assert_equal("#   c_ConstName2& - this parameter is already commented", @result_lines[26])
      assert_equal("#   c_ConstName3& - TODO", @result_lines[27])
      assert_equal("#", @result_lines[28])
    end
  end
  
end
