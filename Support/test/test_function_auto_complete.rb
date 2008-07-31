require File.dirname(__FILE__) + "/test_helper"

require "function_auto_complete"

class TestFunctionAutoComplete < Test::Unit::TestCase
  context "test env -" do
    setup do
      ENV['EPM_ENV'] = 'test' # uses fixtures instead of live access to SV
    end
    
    context "for known partial with only 1 function interface and multiple parameters" do
      setup do
        TextMate::UI.expects(:request_item).
          with(:title => "Select function", :items => %w[ReferenceCodeByLabel&]).
          returns('ReferenceCodeByLabel&')
        @result = FunctionAutoComplete.run("Ref")
      end

      should "return one result" do
        assert_equal('ReferenceCodeByLabel&(${1:c_Code\$}, ${2:c_Reference\$})', @result)
      end
    end
    
    context "for known partial with multiple function interfaces" do
      setup do
        expected_interfaces = ["fTT_Date~()", "fTT_Date~(const c_DaysAgo&)"]
        TextMate::UI.expects(:request_item).
          with(:title => "Select function", :items => %w[fTT_Date~]).
          returns('fTT_Date~')
        TextMate::UI.expects(:request_item).
          with(:title => "Select interface", :items => expected_interfaces).
          returns('fTT_Date~(const c_DaysAgo&)')
        @result = FunctionAutoComplete.run("fTT_Date")
      end

      should "return one result" do
        assert_equal('fTT_Date~(${1:c_DaysAgo&})', @result)
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