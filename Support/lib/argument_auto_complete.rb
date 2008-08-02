class ArgumentAutoComplete
  attr_reader :helper
  def initialize(function_name, line, line_index)
    @helper = self.class.const_get(function_name).new(line, line_index)
  end
  
  def argument_no
    helper.argument_no
  end
  
  def argument?
    helper.argument?
  end
  
  def replace_argument(new_value)
    helper.replace_argument(new_value)
  end
  
  def replace_argument_with_string(new_string)
    helper.replace_argument_with_string(new_string)
  end
  
  def line
    helper.line
  end
  
  class FunctionLineParser
    attr_reader :line, :line_index, :original_line
    attr_reader :argument_no
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
      return unless @is_argument = (before =~ /#{self.function_name}\(([^)]*)$/)
      before_arguments = $1
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

  class ReferenceCodeByLabel < FunctionLineParser
    def function_name; "ReferenceCodeByLabel&"; end
  end
end
