require File.dirname(__FILE__) + "/test_helper"

require "function_auto_complete"

class TestFunctionAutoComplete < Test::Unit::TestCase
  context "test env -" do
    setup do
      ENV['EPM_ENV'] = 'test' # uses fixtures instead of live access to SV
    end
    
    context "for known partial with only 1 function interface and multiple parameters" do
      setup do
        expected_items = %w[ReferenceCodeByLabel&]
        TextMate::UI.expects(:request_item).
          with(:title => "Select function", :items => expected_items).
          returns('ReferenceCodeByLabel&')
        @result = FunctionAutoComplete.run("Ref")
      end

      should "return one result" do
        assert_equal('ReferenceCodeByLabel&(${1:c_Code\$}, ${2:c_Reference\$})', @result)
      end
    end
    
    context "for unknown partial without matches" do
      setup do
        expected_items = %w[]
        TextMate::UI.expects(:request_item).
          with(:title => "Select function", :items => expected_items).
          returns(nil)
        @result = FunctionAutoComplete.run("XXX")
      end

      should "return nothing" do
        assert_equal('XXX', @result)
      end
    end
    
  end
end