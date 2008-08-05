require File.dirname(__FILE__) + "/test_helper"

require "function_defn"

class Context
  def should_convert_filename(filename, function_name)
    should "convert filename '#{filename}' to function name '#{function_name}'" do
      assert_equal(function_name, FunctionDefn.filename_to_function_name(filename))
    end
  end
end
class TestFunctionDefn < Test::Unit::TestCase
  context "test env -" do
    setup do
      ENV['EPM_ENV'] = 'test' # uses fixtures instead of live access to SV
    end

    should "load function definition with no parameters" do
      func = FunctionDefn.find_by_name("fT2_CMN_Rounding_Lookup?{}").values.first
      assert_not_nil(func)
      assert_equal("fT2_CMN_Rounding_Lookup?{}", func.name)
      assert_equal([], func.parameters)
    end

    should "load function definition with parameters" do
      func = FunctionDefn.find_by_name("ReferenceCodeByLabel&").values.first
      assert_not_nil(func)
      assert_equal("ReferenceCodeByLabel&", func.name)
      assert_equal(%w[c_Code$ c_Reference$], func.parameters)
    end
    
    should "load function and have correct name" do
      assert_equal("ReferenceCodeByLabel&", FunctionDefn.find_by_name("ReferenceCodeByLabel&").values.first.name)
      assert_equal("fTT_RAT_ChgMethod#", FunctionDefn.find_by_name("fTT_RAT_ChgMethod#").values.first.name)
      assert_equal("fT2_CMN_Rounding_Lookup?{}", FunctionDefn.find_by_name("fT2_CMN_Rounding_Lookup?{}").values.first.name)
    end
    
    should "find multiple interfaces" do
      interfaces = FunctionDefn.find_by_name("fTT_Date~")
      assert_equal([1, 2], interfaces.keys.sort)
    end
  end
  
  context "epm_function file names" do
    should_convert_filename "treEventSubscribe-integer-1.epm", "treEventSubscribe&"
    should_convert_filename "fTT_TIP_GetMediaChannels.RPC-unknownhash-1.epm", "fTT_TIP_GetMediaChannels.RPC?{}"
    should_convert_filename "treStatsDate-date-1.epm", "treStatsDate~"
    should_convert_filename "fT2_TRT_CollectionGetData-unknownarray-1.epm", "fT2_TRT_CollectionGetData?[]"
    should_convert_filename "biFunctionVariablesUsed-stringarray-1.epm", "biFunctionVariablesUsed$[]"
    should_convert_filename "biServiceSubtotalFetch-realhash-4.epm", 'biServiceSubtotalFetch#{}'
    should_convert_filename "biAdjustmentAdjustAmount-real-1.epm", "biAdjustmentAdjustAmount#"
  end
  
  # find * | sed -e "s/.*\///" | grep "epm$"
end