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
  
  def should_be_for_function(function_name)
    should "be for function #{function_name}" do
      assert_equal(function_name, @arg_auto.function_name)
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
        @arg_auto = ArgumentAutoComplete.new([line], 1, 62)
      end
      
      should "be invalid to autocomplete" do
        assert(!@arg_auto.argument?)
      end
      
      should_be_argument -1
      should_be_for_function nil
    end
    
    context "with cursor just inside parentheses" do
      setup do
        @arg_auto = ArgumentAutoComplete.new([line], 1, 64)
      end

      should_be_valid_to_autocomplete
      should_be_argument 1
      should_be_for_function 'ReferenceCodeByLabel&'

      should "replace argument with XXX" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&(XXX, '00_000000001'));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
        assert_equal(expected_line, @arg_auto.document)
      end
    end
    
    context "with cursor inside 1st argument string" do
      setup do
        @arg_auto = ArgumentAutoComplete.new([line], 1, 67)
      end

      should_be_valid_to_autocomplete
      should_be_argument 1
      should_be_for_function 'ReferenceCodeByLabel&'
      
      should "replace argument with XXX" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&(XXX, '00_000000001'));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
        assert_equal(expected_line, @arg_auto.document)
      end

      should "replace argument with an EPM string" do
        @arg_auto.replace_argument_with_string('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('XXX', '00_000000001'));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
        assert_equal(expected_line, @arg_auto.document, "document not created correctly")
      end
    end

    context "with cursor just after comma between arguments" do
      setup do
        @arg_auto = ArgumentAutoComplete.new([line], 1, 86)
      end

      should_be_valid_to_autocomplete
      should_be_argument 2
      should_be_for_function 'ReferenceCodeByLabel&'

      should "replace 2nd argument with XXX" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('T2_CC_RETAILER_CODE', XXX));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
        assert_equal(expected_line, @arg_auto.document)
      end
    end

    context "with cursor just inside final parameter" do
      setup do
        @arg_auto = ArgumentAutoComplete.new([line], 1, 101)
      end

      should_be_valid_to_autocomplete
      should_be_argument 2
      should_be_for_function 'ReferenceCodeByLabel&'

      should "replace 2nd argument with XXX" do
        @arg_auto.replace_argument('XXX')
        expected_line = <<-LINE
const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('T2_CC_RETAILER_CODE', XXX));
        LINE
        assert_equal(expected_line.strip, @arg_auto.line)
        assert_equal(expected_line, @arg_auto.document)
      end
    end

    
  end
  
  context "multi-line document" do
    setup do
      @document = <<-LINE.strip
fSomeFunction&() =
{
  const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('T2_CC_RETAILER_CODE', '00_000000001'));
  return 0;
}
      LINE
    end

    context "with cursor inside 1st argument string" do
      setup do
        @arg_auto = ArgumentAutoComplete.new(@document.split("\n"), 3, 69)
      end

      should "replace argument with an EPM string" do
        @arg_auto.replace_argument_with_string('XXX')
        expected_document = <<-LINE
fSomeFunction&() =
{
  const cDefaultRetailerCode$ := to_string(ReferenceCodeByLabel&('XXX', '00_000000001'));
  return 0;
}
        LINE
        assert_equal(expected_document, @arg_auto.document)
      end
    end
  end
  
end