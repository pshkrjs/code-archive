package com.company;

import java.util.Random;
import java.util.Scanner;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Main{

    static Scanner scanner = new Scanner(System.in);

    public static void main(String[] args){

        double[][] equation;
        double fDashX, fX = 0;
        double x;
        Double epsilon;
        double lower;
        double upper;
        long iter = 0;
        Random random;

        System.out.println("Enter lower bound:");
        lower = scanner.nextDouble();
        System.out.println("Enter upper bound:");
        upper = scanner.nextDouble();
        random = new Random();
        // calculate random value for x between lower-upper bounds
        x = lower + random.nextDouble() * (upper-lower);
        // (upper-lower)/(upper-lower)^2
        epsilon = initEpsilon();

        // get coefficients and powers
        equation = getEquation();
        fDashX = getFDashX(equation, x);

        boolean signPositive = true;

        if (fDashX < 0)
            signPositive = false; // initial sign

        double prevX;
        do {
            prevX = x;
            x += epsilon * fDashX; // new x
            if (prevX == x){
                x = lower + random.nextDouble() * (upper - lower);
                epsilon = initEpsilon();
            }
            if (x < lower || x > upper){
                epsilon = initEpsilon();
                x = lower + random.nextDouble() * (upper - lower);
            }
            if (signPositive == (fDashX < 0)){
                epsilon /= 2;// decrease step if sign changes
            }
            fDashX = getFDashX(equation, x);
            fX = getfX(equation, x);
            iter++;
            System.out.printf("\nI%d:  X=%.15f f(X)=%.15f f'(X)=%.15f", iter, x, fX, fDashX);
        }while (Math.abs(fDashX) > 1.0E-10);

// Coefficients and powers in equation
//        for (double[] some:equation) {
//            System.out.println(String.valueOf(some[0]).concat(" ").concat(String.valueOf(some[1])));
//        }
        System.out.printf("\nFinal Result:\nX=%.15f f(X)=%.15f f'(X)=%.15f", x, fX, fDashX);
    }

    private static Double initEpsilon() {
        return new Double(0.5);
    }

    // calculate f(x)
    private static double getfX(double[][] equation, double x) {

        double fX = 0;

        for (double[] coeff:equation) {
            fX += coeff[0] * Math.pow(x,coeff[1]);
        }

        return fX;
    }

    // calculate f'(x)
    private static double getFDashX(double[][] equation, double x) {

        double fDashX = 0;

        for (double[] coeff:equation) {
            if (coeff[1]!=0)
                fDashX += coeff[0] * coeff[1] * Math.pow(x, coeff[1]-1);
        }

        return fDashX;
    }

    // return coefficients and powers
    private static double[][] getEquation() {

        double[][] equation;
        String polynomial;
        Pattern pattern;
        Matcher matcher;
        int count,i;
        String temp, temp2[];
        boolean flagX;

        System.out.println("Enter polynomial equation:");
        polynomial = scanner.next();
        // break equation in terms of x
        pattern = Pattern.compile("([-\\+]?[0-9\\.]*[a-zA-Z]?\\^?[0-9\\.]*)");// counts "" too
        matcher = pattern.matcher(polynomial);
        count = 0;
        i = 0;
        // count number of terms
        while(matcher.find())
            count++;
        equation = new double[--count][2];
        matcher = pattern.matcher(polynomial);
        while (matcher.find()){
            flagX = false;
            temp = matcher.group(0);
            temp2 = temp.split("[a-zA-Z]\\^?");// split into coefficient and power
            try {
                equation[i][0] = Double.valueOf(temp2[0]);
            } catch (Exception e){
                if (e.getMessage().equals("empty String"))// no coefficient
                    equation[i][0] = new Double(1);
                else if (e.getMessage().equals("For input string: \"-\"")){// negative coefficient 1 of x
                    equation[i][0] = new Double(-1);
                    flagX = true;
                } else if (e.getMessage().equals("0")){
                    equation[i][0] = new Double(1);// no coefficient or power
                    flagX = true;
                }
            } finally {
                try{
                    equation[i][1] = Double.valueOf(temp2[1]);
                } catch (Exception e){
                    if (e.getMessage().equals("1")) {
                        if (flagX)// no power or coefficient
                            equation[i][1] = new Double(1);
                        else if (count == 1)
                            continue;
                        else// no power
                            equation[i][1] = new Double(0);
                    }
                } finally {
                    i++;
                }
            }
        }

        return equation;
    }
}