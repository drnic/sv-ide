require "ostruct"
require "yaml"
class FunctionDefn < OpenStruct
  # Returns FunctionDefn for function with +name+ (e.g. ReferenceCodeByLabel&)
  # The result is always a hash with the key a number 1+ representing its interface number
  # Normally there is only one interface, so the result will be {1 => <FunctionDefn name=ReferenceCodeByLabel&>}
  def self.find_by_name(name)
    function_defns[name]
  end
  
  # Returns a list of function names that start with +partial+
  # Note, there may be 1+ interface versions for each result
  def self.find_by_partial(partial)
    function_defns.keys.select { |func_name| func_name =~ /^#{partial}/ }
  end
  
  # If no parameters provided to initializer, then return empty array.
  # Parameters should be an array of strings
  # If signature of function is: ReferenceCodeByLabel&(const c_Code$, const c_Reference$)
  # Then parameters will be: ['c_Code$', 'c_Reference$']
  def parameters
    super || []
  end
  
  def self.filename_to_function_name(filename)
    name, type, interface_no = filename.gsub('.epm', '').split('-')
    "#{name}#{typecode_by_name[type]}"
  end
  
  def self.typecode_by_name
    @@typecode_by_name ||= {
      'blob' => '@',
      'date' => '~',
      'string' => '$',
      'integer' => '&',
      'real' => '#',
      'unknown' => '?',

      'blobarray' => '@[]',
      'datearray' => '~[]',
      'stringarray' => '$[]',
      'integerarray' => '&[]',
      'realarray' => '#[]',
      'unknownarray' => '?[]',

      'datehash' => '~{}',
      'stringhash' => '${}',
      'integerhash' => '&{}',
      'realhash' => '#{}',
      'unknownhash' => '?{}',
      'blobhash' => '@{}',
      }
  end
  
  protected
  def self.function_defns
    test_env? ? function_defns_by_fixtures : function_defns_by_thp
  end
  
  def self.function_defns_by_fixtures
    function_defns = YAML.load(File.read(File.dirname(__FILE__) + "/../fixtures/function_defns.yml"))
    function_defns.inject({}) do |mem, func_def|
      name_interface, func = func_def
      name, interface = name_interface.split('-')
      full_name = func["name"]
      mem[full_name] ||= {}
      mem[full_name][interface.to_i] = self.new(func)
      mem
    end
  end
  
  def self.function_defns_by_thp
    # TODO; including caching of results
  end

  def self.test_env?
    ENV['EPM_ENV'] == 'test'
  end
end