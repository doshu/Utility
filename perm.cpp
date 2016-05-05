#include <iostream>
#include <string>
#include <math.h>
#include <cstdlib>
#include <thread>
#include <future>

using namespace std;

//4.3 => 4 / 3
int permutations(string alphabet, int output_length, int offset) {
	int iterations = pow(alphabet.length(), output_length-1);
	string* output = new string[iterations];
	int oi = 0; 
	if(alphabet.length() && output_length > 0) {
		if (alphabet.length() < 2) 
			return 0;
			
		int pointer[output_length];
		std::fill(pointer, pointer + output_length, 0);
		pointer[0] = offset;
		
		int alphabet_length = alphabet.length();
      	output_length--;
  
      	for (int i = 0; i < iterations; i++) {
        	string permutation = "";
        	int c;
        	for (c = 0; c <= output_length; c++) {
          		string tmp(1, alphabet.at(pointer[c]));
          		permutation += tmp;
        	}
        	
			string cmd = string("unrar t -y -p")+permutation+string(" ./a.rar 1>/dev/null 2>&1");
			if(system(cmd.c_str()) == 0) {
				string echo = string("echo \"")+permutation+string("\" > /tmp/password");
				cout<<"La password è: "<<permutation;
				system(echo.c_str());
				return 0;
			}

	  
		    c = output_length;
	  
		    do {
				pointer[c]++;
				if (pointer[c] < alphabet_length) {
		        	break;
		      	} else {
		        	pointer[c] = 0;
		        	c--;
		      	}
		    } while (true);
		}
	}
	return 1;
}

int main() {

	string a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	int t = a.length();
	thread pool[t];
	for(int d = 1; d < 10; d++) {
		for(int i = 0; i < t; i++) {
			pool[i] = thread(permutations, a, 3, i);
		}
		for(int i = 0; i < t; i++) {
			pool[i].join();
		}
	}
	//thread first(permutations, a, 3, 2, 0);
	//thread second(permutations, a, 3, 2, 1);
	//first.join();
	//second.join();
	return 0;
}
