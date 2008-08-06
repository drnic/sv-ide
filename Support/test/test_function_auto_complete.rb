require File.dirname(__FILE__) + "/test_helper"

require "function_auto_complete"

class TestFunctionAutoComplete < Test::Unit::TestCase
  context "for known partial with only 1 function interface and multiple parameters" do
    setup do
      @result = FunctionAutoComplete.new.run("ReferenceCodeByLabe")
    end

    should "return one result" do
      assert_equal('ReferenceCodeByLabel&(${1:ReferenceTypeLabel\$}, ${2:ReferenceCodeLabel\$})', @result)
    end
  end
  
  context "for known partial with multiple function interfaces" do
    setup do
      expected_interfaces = ["ReferenceCodeValidate&(const ReferenceTypeLabel$, const ReferenceCode&, const FieldName$)", 
                "ReferenceCodeValidate&(const ReferenceTypeLabel$, const ReferenceCode&)"]
      TextMate::UI.expects(:menu).
        with(expected_interfaces.map { |i| {"title" => i} }).
        returns({"title" => 'ReferenceCodeValidate&(const ReferenceTypeLabel$, const ReferenceCode&)'})
      @result = FunctionAutoComplete.new.run("ReferenceCodeValida")
    end

    should "return one result" do
      assert_equal('ReferenceCodeValidate&(${1:ReferenceTypeLabel\$}, ${2:ReferenceCode&})', @result)
    end
  end
  
  context "for unknown partial without matches" do
    setup do
      expected_items = %w[]
      @result = FunctionAutoComplete.new.run("XXX")
    end

    should "return nothing" do
      assert_equal('XXX', @result)
    end
  end
  
end