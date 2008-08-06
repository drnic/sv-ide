class FunctionDefnParser
  attr_reader :lines
  attr_reader :name, :parameter_defns, :parameters, :signature
  
  def initialize(document_lines)
    @lines = document_lines
    parse
  end
  
  protected
  def parse
    parse_function_signature
  end
  
  def doc_no_lines
    lines.map { |line| line.gsub(/(?:^|\s)#.*/,'').gsub(/\n/,"") }.join # remove comments from end of each line
  end
  
  def parse_function_signature
    if doc_no_lines =~ /([\w_]+[$&#~@?]?(?:\{\}|\[\])?)\((.*)\)[\s\t]*=/
      @name, parameter_str = $1, $2
      @parameter_defns     = parameter_str.split(/[\s\t]*,[\s\t]*/).map { |param_str| param_str.split.reverse }
      @parameters          = parameter_defns.map { |name, defn| name }
      arguments            = parameter_defns.map { |name, defn| "#{defn} #{name}".strip }.join(', ')
      @signature           = "#{name}(#{arguments})"
    end
  end
end
