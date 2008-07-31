#!/usr/bin/env ruby
#
# Parameter Comments Command

require File.dirname(__FILE__) + '/../lib/function_defn_parser'

class ParameterComments
  attr_reader :function
  
  def run(function_document_lines)
    @function = FunctionDefnParser.new(function_document_lines)
    parameters = function.parameters
    
    # locate PARAMETERS: block in header
    parameter_block, param_start_line, param_end_line = parse_parameter_block

    # (optional) determine if any parameter comments already exist
    
    # replace PARAMETERS: block with parameter stubs
    new_parameter_block = generate_parameter_block(parameters)
    
    # output
    (function_document_lines[0..param_start_line-1] +
      [new_parameter_block] +
      function_document_lines[param_end_line+2..-1]).join
  end
  
  def parse_parameter_block
    ["# PARAMETERS:\n#   c_ChargeMethod& - Charge Method.\n", 25, 26]
  end
  
  def generate_parameter_block(parameters)
    "# PARAMETERS:\n" +
    if parameters.size == 0 
      "#   None\n"
    else
      "#   c_ChargeMethod& - TODO\n"
    end +
    "#\n"
  end
end

if $0 == __FILE__
  print ParameterComments.new.run(STDIN.readlines)
end