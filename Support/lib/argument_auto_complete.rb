class ArgumentAutoComplete
  attr_reader :line, :line_index, :original_line
  attr_reader :function_name, :argument_no

  def initialize(line, line_index)
    @line, @line_index = line, line_index
    @original_line     = line
    parse
  end

  def argument?
    @is_argument
  end

  def replace_argument(new_value)
    @line = original_line[0..@arg_start_index-1] + 
      new_value + original_line[@arg_end_index..-1]
  end
  
  def replace_argument_with_string(new_string)
    replace_argument("'#{new_string}'")
  end
  
  protected
  def parse
    before, after = line[0..line_index-1], line[line_index..-1]
    @argument_no = -1
    return unless @is_argument = (before =~ /\b([\w_]+[$&#~@?](?:\{\}|\[\])?)\(([^)]*)$/)
    @function_name, before_arguments = $1, $2
    @argument_no = (commas = before_arguments.match(/,/)) ? commas.length : 1
    return unless @is_argument = (after =~ /^([^)]+)\)/)
    @arg_start_index, @arg_end_index = line_index, line_index
    until line[@arg_start_index-1..@arg_start_index-1] =~ /[(,]/
      @arg_start_index = @arg_start_index - 1
    end
    until line[@arg_end_index..@arg_end_index] =~ /[),]/
      @arg_end_index = @arg_end_index + 1
    end
  end
end
