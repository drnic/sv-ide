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
  
  class FunctionLineParser
    attr_reader :line, :line_index
    attr_reader :argument_no
    def initialize(line, line_index)
      @line, @line_index = line, line_index
      parse
    end

    def argument?
      @is_argument
    end
    
    protected
    def parse
      before, after = line[0..line_index-1], line[line_index..-1]
      @argument_no = -1
      if @is_argument = before =~ /#{self.function_name}\(([^)]*)$/
        before_arguments = $1
        @argument_no = (commas = before_arguments.match(/,/)) ? commas.length : 1
        if @is_argument = after =~ /^([^)]+)\)/
          after_arguments = $1
        end
      end
    end
  end

  class ReferenceCodeByLabel < FunctionLineParser
    def initialize(line, line_index)
      super
    end
    
    def function_name; "ReferenceCodeByLabel&"; end
  end
end