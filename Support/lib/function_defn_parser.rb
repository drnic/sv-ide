class FunctionDefnParser
  attr_reader :lines
  attr_reader :name, :parameter_defns, :parameters, :signature
  
  def initialize(document_lines)
    @lines = document_lines
    parse
  end
  
  protected
  def parse
    lines.each do |line|
      next if line =~ /^#/
      # TODO - parse multi-line signatures
      # TODO - parse description
      parse_function_signature(line)
      break if name && parameters
    end
  end
  
  def doc_no_lines
    lines.join
  end
  
  def parse_function_signature(line)
    if doc_no_lines =~ /([\w_]+[$&#~@?]?(?:\{\}|\[\])?)\((.*)\)\s*=/
      @name, parameter_str = $1, $2
      @parameter_defns     = parameter_str.split(/\s*,\s*/).map { |param_str| param_str.split }
      @parameters          = parameter_defns.map { |defn, name| name }
      @signature           = "#{name}(#{parameter_defns.map { |defn, name| "#{defn} #{name}" }.join(', ')})"
    end
  end
end
