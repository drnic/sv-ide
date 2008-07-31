require File.dirname(__FILE__) + "/test_helper"

require "function_auto_complete"

class TestFunctionAutoComplete < Test::Unit::TestCase
  context "test env -" do
    setup do
      ENV['EPM_ENV'] = 'test' # uses fixtures instead of live access to SV
    end
    
    context "for known partial with matches" do
      setup do
        expected_items = %w[fTT_RAT_ChgMethod#]
        TextMate::UI.expects(:request_item).
          with(:title => "Select function", :items => expected_items).
          returns('fTT_RAT_ChgMethod#')
        @result = FunctionAutoComplete.run("fTT_RAT")
      end

      should "return one result" do
        assert_equal("fTT_RAT_ChgMethod#", @result)
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