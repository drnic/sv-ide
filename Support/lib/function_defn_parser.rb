class FunctionDefnParser
  attr_reader :lines
  attr_reader :name, :parameters
  
  def initialize(document_lines)
    @lines = document_lines
    parse
  end
  
  protected
  def parse
    lines.each do |line|
      next if line =~ /^#/
      parse_function_signature(line)
      break if name && parameters
    end
  end
  
  def parse_function_signature(line)
    if line =~ /([\w_]+[$&#~?]?)\((.*)\)\s*=/
      @name, parameter_str = $1, $2
      @parameters = parameter_str.split(/\s*,\s*/).map { |param_str| param_str.split.last }
    end
  end
end