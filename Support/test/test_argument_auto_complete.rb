require File.dirname(__FILE__) + "/test_helper"
require "argument_auto_complete"

class Context
  def should_be_valid_to_autocomplete
    should "be valid to autocomplete" do
      assert(@arg_auto.argument?)  
    end
  end

  def should_be_argument(num)
    should "be argument #{num}" do
      assert_equal(num, @arg_auto.argument_no)
    end
  end
end
class TestArgumentAutoComplete < Test::Unit::TestCase
  attr_reader :line, :line_index
  
  context "inside ReferenceCodeByLabel& call" do
    setup do
      @line = <<-LINE.strip
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('T2_CC_RETAILER_CODE', '00_000000001'));
      LINE
    end

    context "with cursor before parentheses" do
      setup do
        @line_index = 62
        @arg_auto = ArgumentAutoComplete.new('ReferenceCodeByLabel', line, line_index)
      end
      
      should "be invalid to autocomplete" do
        assert(!@arg_auto.argument?)
      end
      
      should_be_argument -1
    end
    
    context "with cursor just inside parentheses" do
      setup do
        @line_index = 64
        @arg_auto = ArgumentAutoComplete.new('ReferenceCodeByLabel', line, line_index)
      end

      should_be_valid_to_autocomplete
      should_be_argument 1

      should "replace argument with 'XXX'" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&(XXX, '00_000000001'));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
      end
    end
    
    context "with cursor inside 1st argument string" do
      setup do
        @line_index = 67
        @arg_auto = ArgumentAutoComplete.new('ReferenceCodeByLabel', line, line_index)
      end

      should_be_valid_to_autocomplete
      should_be_argument 1
      
      should "replace argument with 'XXX'" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&(XXX, '00_000000001'));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
      end
    end
    
  end
  
end